#!/usr/bin/env python3
"""
Extrae texto e imágenes incrustadas de un PDF de catálogo.
No interpreta el diseño (columnas/tablas): revisar los .txt y asociar precios manualmente o con ayuda.

Uso:
  python tools/extract_catalog_pdf.py ruta/al/catalogo.pdf [carpeta_salida]

Salida:
  - page_XXX.txt   texto OCR/simple por página
  - pageXXX_imgN.<ext>  imágenes embebidas
  - pages.json     todas las cadenas de texto por página (para procesamiento)

Dependencia: pip install pymupdf
"""
from __future__ import annotations

import json
import sys
from pathlib import Path


def main() -> None:
    if len(sys.argv) < 2:
        print(__doc__)
        sys.exit(1)

    try:
        import fitz  # PyMuPDF
    except ImportError:
        print("Instala: pip install pymupdf")
        sys.exit(1)

    pdf_path = Path(sys.argv[1]).resolve()
    if not pdf_path.is_file():
        print(f"No existe el archivo: {pdf_path}")
        sys.exit(1)

    out = Path(sys.argv[2]).resolve() if len(sys.argv) > 2 else pdf_path.parent / f"{pdf_path.stem}_export"
    out.mkdir(parents=True, exist_ok=True)

    doc = fitz.open(pdf_path)
    pages_data: list[dict] = []
    img_count = 0

    for i, page in enumerate(doc):
        pnum = i + 1
        text = page.get_text()
        (out / f"page_{pnum:03d}.txt").write_text(text or "(sin texto extraíble)\n", encoding="utf-8")
        pages_data.append({"page": pnum, "text": text})

        for img_index, img in enumerate(page.get_images(full=True)):
            xref = img[0]
            try:
                base = doc.extract_image(xref)
            except Exception:
                continue
            ext = base.get("ext", "png")
            img_count += 1
            fname = out / f"page{pnum:03d}_img{img_index + 1}.{ext}"
            fname.write_bytes(base["image"])

    summary = {"pdf": str(pdf_path), "pages": len(doc), "embedded_images_written": img_count}
    (out / "pages.json").write_text(json.dumps(pages_data, ensure_ascii=False, indent=2), encoding="utf-8")
    (out / "_extract_summary.json").write_text(json.dumps(summary, indent=2), encoding="utf-8")

    doc.close()
    print(f"Listo: {len(pages_data)} páginas, {img_count} imágenes → {out}")


if __name__ == "__main__":
    main()
