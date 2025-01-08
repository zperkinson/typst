#let quotes(contents) = {
  for (quotes, lines) in contents {
    for line in lines [
      - #line
    ]
  }
}

#quotes(
  yaml("data.yml")
)
