"""Builds subjects.html so the 25 subject tiles stay consistent.
Edit SUBJECTS, re-run, and the page is rebuilt. Not shipped to production —
it exists so the tile markup is written once rather than 25 times by hand."""

# name, bootstrap icon, tint class, qualifications, search keywords
SUBJECTS = [
    ("Core", [
        ("Mathematics",        "calculator",        "tint-mint",       ["gcse", "igcse", "alevel"], "maths numeracy algebra"),
        ("Further Mathematics","plus-slash-minus",  "tint-mint",       ["gcse", "alevel"],          "further maths fp1 additional"),
        ("Statistics",         "bar-chart-line",    "tint-mint",       ["gcse", "alevel"],          "stats data probability"),
        ("English Language",   "chat-square-text",  "tint-blush",      ["gcse", "igcse"],           "english language writing comprehension"),
        ("English Literature", "book",              "tint-blush",      ["gcse", "igcse", "alevel"], "english literature poetry shakespeare novels"),
    ]),
    ("Sciences", [
        ("Biology",            "tree",              "tint-sage",       ["gcse", "igcse", "alevel"], "biology cells genetics ecology"),
        ("Chemistry",          "thermometer-half",  "tint-cream",      ["gcse", "igcse", "alevel"], "chemistry organic bonding moles"),
        ("Physics",            "asterisk",          "tint-sky",        ["gcse", "igcse", "alevel"], "physics forces electricity waves"),
        ("Combined Science",   "diagram-3",         "tint-sage",       ["gcse", "igcse"],           "combined science trilogy double award"),
        ("Computer Science",   "display",           "tint-periwinkle", ["gcse", "alevel"],          "computer science programming python algorithms"),
    ]),
    ("Humanities", [
        ("Geography",          "globe-americas",    "tint-mint",       ["gcse", "igcse", "alevel"], "geography rivers coasts urban fieldwork"),
        ("History",            "hourglass-split",   "tint-cream",      ["gcse", "igcse", "alevel"], "history medicine germany cold war"),
        ("Religious Studies",  "bank",              "tint-lilac",      ["gcse", "alevel"],          "religious studies re ethics philosophy"),
        ("Classical Civilisation", "columns-gap",   "tint-cream",      ["alevel"],                  "classics classical civilisation greece rome"),
    ]),
    ("Social sciences & business", [
        ("Economics",          "graph-up-arrow",    "tint-lilac",      ["gcse", "alevel"],          "economics markets macro micro"),
        ("Business",           "briefcase",         "tint-periwinkle", ["gcse", "alevel"],          "business studies marketing finance"),
        ("Psychology",         "lightbulb",         "tint-blush",      ["gcse", "alevel"],          "psychology memory attachment research methods"),
        ("Sociology",          "people",            "tint-sky",        ["gcse", "alevel"],          "sociology family education crime"),
        ("Politics",           "megaphone",         "tint-periwinkle", ["alevel"],                  "politics government uk us"),
    ]),
    ("Languages", [
        ("French",             "translate",         "tint-sky",        ["gcse", "alevel"],          "french mfl languages"),
        ("Spanish",            "translate",         "tint-cream",      ["gcse", "alevel"],          "spanish mfl languages"),
        ("German",             "translate",         "tint-lilac",      ["gcse", "alevel"],          "german mfl languages"),
    ]),
    ("Creative & technical", [
        ("Art & Design",       "palette",           "tint-blush",      ["gcse", "alevel"],          "art design fine art photography"),
        ("Design & Technology","rulers",            "tint-cream",      ["gcse", "alevel"],          "dt design technology resistant materials"),
        ("Music",              "music-note-beamed", "tint-lilac",      ["gcse", "alevel"],          "music theory composition listening"),
        ("Physical Education", "trophy",            "tint-sage",       ["gcse", "alevel"],          "pe physical education sport anatomy"),
    ]),
]

QUAL_LABELS = {"gcse": "GCSE", "igcse": "IGCSE", "alevel": "A Level"}


def slug(text):
    return text.lower().replace(" & ", "-").replace(" ", "-")


def tile(name, icon, tint, quals, keywords):
    chips = "".join(
        '<span class="qual-chip">%s</span>' % QUAL_LABELS[q] for q in quals
    )
    return f'''        <div class="col">
          <a class="subject-tile" href="resources.html?subject={name.replace(' ', '+').replace('&', 'and')}"
             data-quals="{' '.join(quals)}" data-keywords="{keywords}">
            <span class="tile-icon {tint}"><i class="bi bi-{icon}" aria-hidden="true"></i></span>
            <span class="tile-body">
              <span class="tile-name">{name}</span>
              <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
              <span class="tile-quals">{chips}</span>
            </span>
            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
          </a>
        </div>'''


groups_html = []
jump_html = []
total = 0

for group_name, subjects in SUBJECTS:
    total += len(subjects)
    gid = slug(group_name)
    jump_html.append(
        f'<li><a class="jump-chip" href="#{gid}">{group_name} '
        f'<span class="jump-count">{len(subjects)}</span></a></li>'
    )
    tiles = "\n".join(tile(*s) for s in subjects)
    groups_html.append(f'''      <section class="subject-group" id="{gid}" aria-labelledby="{gid}-heading" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="{gid}-heading">{group_name}</h2>
          <span class="group-count">{len(subjects)} subjects</span>
        </div>
        <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-3">
{tiles}
        </div>
      </section>''')

import os
HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(HERE)

with open(os.path.join(HERE, "subjects.template.html")) as fh:
    template = fh.read()

page = (template
        .replace("{{JUMP}}", "\n            ".join(jump_html))
        .replace("{{GROUPS}}", "\n\n".join(groups_html))
        .replace("{{TOTAL}}", str(total)))

with open(os.path.join(ROOT, "subjects.html"), "w") as fh:
    fh.write(page)

print(f"subjects.html written — {total} subjects across {len(SUBJECTS)} groups")
