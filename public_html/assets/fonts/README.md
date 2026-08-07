# PENDING — General Sans font files

BUILD-SPEC.md §2 specifies self-hosted General Sans woff2, weights 400/450/500.
General Sans is a commercial typeface (Indian Type Foundry / Fontshare). This
build does **not** fabricate or download the binary files without a confirmed
license — that is a licensing decision, not an execution detail.

Until the licensed `.woff2` files are placed here as:

```
GeneralSans-Regular.woff2   (400)
GeneralSans-Medium.woff2    (500)
GeneralSans-Semibold.woff2  (used at display weight per file tree in §7,
                              though §2 only calls out 400/450/500 — confirm
                              which weight file maps to the 450 "450 weight"
                              spec value, since 450 sits between Regular and
                              Medium and General Sans ships as a variable font
                              or as discrete static weights depending on the
                              license tier purchased)
```

`site.css`'s `font-family` stack falls back to `system-ui, sans-serif`, so
pages render correctly with the system font in the meantime — nothing breaks,
but the CLINICAL track's actual type identity isn't live until this is
resolved. The `<link rel="preload" as="font">` tags in `src/partials/head.php`
point at these exact filenames already, ready to work the moment the files
land.
