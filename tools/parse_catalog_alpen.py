#!/usr/bin/env python3
"""
Parsea el texto extraído de catalogoAlpen.pdf (page_XXX.txt) y genera:
  - products_parsed.json
  - woocommerce_import_alpen.csv

SKU en MAYÚSCULAS (como productos manuales en WooCommerce: HM-AP090B-...).
Detecta fin de ficha cuando la siguiente línea es otro producto (ALPEN/HM/EXTREMO/CAMP + precio).
Asigna imagen embebida del PDF por página (mayor tamaño, en orden de aparición).

  python tools/extract_catalog_pdf.py assets/catalogoAlpen.pdf assets/catalogoAlpen_export
  python tools/parse_catalog_alpen.py
"""
from __future__ import annotations

import csv
import json
import re
import sys
from collections import Counter
from pathlib import Path

THEME = Path(__file__).resolve().parent.parent
EXPORT = THEME / "assets" / "catalogoAlpen_export"

price_re = re.compile(r"^\$\s*([\d.,]+)\s*$")
SKIP_LINES = {
    "PRODUCTOS",
    "PRECIO SUGERIDO",
    "AL PUBLICO",
    "EQUIPOS DE CALIDAD CERTIFICADA",
}
BRAND_PREFIXES = ("ALPEN ", "HM ", "EXTREMO ", "CAMP ")
MIN_IMAGE_BYTES = 4000


def sku_from_name(name: str) -> str:
    s = re.sub(r"[^a-zA-Z0-9]+", "-", name.strip())
    s = re.sub(r"-+", "-", s).strip("-")
    return s.upper()[:96] or "SKU"


def is_product_title(line: str, next_line: str | None) -> bool:
    if not line or not next_line:
        return False
    if not price_re.match(next_line):
        return False
    upper = line.upper()
    return any(upper.startswith(p) for p in BRAND_PREFIXES)


def page_number_from_stem(stem: str) -> int:
    return int(stem.split("_")[1])


def product_images_for_page(folder: Path, page_num: int) -> list[str]:
    imgs = sorted(folder.glob(f"page{page_num:03d}_img*.*"))
    out: list[str] = []
    for img in imgs:
        if img.stat().st_size < MIN_IMAGE_BYTES:
            continue
        out.append(img.name)
    return out


def parse_export(folder: Path) -> list[dict]:
    products: list[dict] = []
    for p in sorted(folder.glob("page_*.txt")):
        page_num = page_number_from_stem(p.stem)
        page_images = product_images_for_page(folder, page_num)
        img_idx = 0

        lines = [ln.strip() for ln in p.read_text(encoding="utf-8").splitlines()]
        i = 0
        while i < len(lines):
            ln = lines[i]
            if not ln or ln in SKIP_LINES:
                i += 1
                continue
            if i + 1 < len(lines) and price_re.match(lines[i + 1]) and is_product_title(ln, lines[i + 1]):
                name = ln
                price_display = lines[i + 1].strip()
                cop_raw = price_re.match(price_display).group(1).replace(".", "").replace(",", "")
                try:
                    price_num = int(cop_raw)
                except ValueError:
                    price_num = None
                desc_lines: list[str] = []
                j = i + 2
                while j < len(lines):
                    nxt = lines[j]
                    nxt2 = lines[j + 1] if j + 1 < len(lines) else None
                    if is_product_title(nxt, nxt2):
                        break
                    if nxt == "PRODUCTOS":
                        j += 1
                        break
                    desc_lines.append(nxt)
                    j += 1
                desc_txt = "\n".join(x for x in desc_lines if x).strip()
                udesc = desc_txt.upper()
                stock = "instock"
                if "AGOTADO" in udesc:
                    stock = "outofstock"
                if "PROXIMAMENTE" in udesc:
                    stock = "onbackorder"

                image_file = ""
                if img_idx < len(page_images):
                    image_file = page_images[img_idx]
                    img_idx += 1

                products.append(
                    {
                        "source_page": p.stem,
                        "source_page_num": page_num,
                        "sku": sku_from_name(name),
                        "name": name,
                        "regular_price": price_num,
                        "price_display_cop": price_display,
                        "description": desc_txt,
                        "stock_status": stock,
                        "image_file": image_file,
                    }
                )
                i = j
                continue
            i += 1
    return products


def dedupe_skus(products: list[dict]) -> None:
    seen: dict[str, int] = {}
    for p in products:
        base = p["sku"]
        if base not in seen:
            seen[base] = 0
        seen[base] += 1
        if seen[base] > 1:
            p["sku"] = f"{base}-{seen[base]}"


def main() -> None:
    folder = EXPORT
    if len(sys.argv) > 1:
        folder = Path(sys.argv[1]).resolve()
    if not folder.is_dir():
        print(f"No existe la carpeta de exportación: {folder}")
        sys.exit(1)

    products = parse_export(folder)
    counts_pre = Counter(p["sku"] for p in products)
    if any(v > 1 for v in counts_pre.values()):
        dedupe_skus(products)

    out_json = folder / "products_parsed.json"
    out_csv = folder / "woocommerce_import_alpen.csv"
    out_json.write_text(json.dumps(products, ensure_ascii=False, indent=2), encoding="utf-8")

    fields = [
        "type",
        "sku",
        "name",
        "published",
        "regular_price",
        "description",
        "stock_status",
        "images",
    ]
    with out_csv.open("w", newline="", encoding="utf-8-sig") as f:
        w = csv.DictWriter(f, fieldnames=fields, extrasaction="ignore")
        w.writeheader()
        for pr in products:
            w.writerow(
                {
                    "type": "simple",
                    "sku": pr["sku"],
                    "name": pr["name"],
                    "published": "1",
                    "regular_price": str(pr["regular_price"]) if pr["regular_price"] else "",
                    "description": pr["description"].replace("\n", "<br/>"),
                    "stock_status": pr["stock_status"],
                    "images": pr.get("image_file", ""),
                }
            )

    with_img = sum(1 for p in products if p.get("image_file"))
    print(f"Productos: {len(products)} (con imagen PDF: {with_img})")
    print(out_json)
    print(out_csv)


if __name__ == "__main__":
    main()
