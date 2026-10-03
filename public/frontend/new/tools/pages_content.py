"""Content for the generated pages of Merit Study Resources.

Separated from the builder so copy can be edited without touching markup.
LEGAL COPY IS A STARTING TEMPLATE, NOT LEGAL ADVICE — have a solicitor review
the privacy, terms, refund and cookie pages before publishing, and replace
every [bracketed] placeholder.
"""

COMPANY = {
    "name": "Merit Study Resources",
    "legal": "[Registered company name]",
    "number": "[Company number]",
    "address": "[Registered address]",
    "email": "hello@meritstudyresources.co.uk",
    "privacy_email": "privacy@meritstudyresources.co.uk",
    "updated": "1 September 2026",
}

# --------------------------------------------------------------------------
# Legal / policy pages — (heading, [blocks]) where a block is a paragraph
# string, or ("list", [items]), or ("table", [headers], [[cells]])
# --------------------------------------------------------------------------

PRIVACY = {
    "slug": "privacy",
    "title": "Privacy policy",
    "intro": "This policy explains what we collect when you use Merit Study Resources, "
             "why we collect it, and what you can ask us to do with it.",
    "sections": [
        ("Who we are", [
            f"{COMPANY['name']} is operated by {COMPANY['legal']}, registered in England and Wales "
            f"(company number {COMPANY['number']}), registered office {COMPANY['address']}.",
            f"We are the data controller for personal data collected through this site. For anything "
            f"in this policy, contact {COMPANY['privacy_email']}.",
        ]),
        ("What we collect", [
            "You can browse and download almost everything on this site without giving us any personal data.",
            ("list", [
                "<strong>Account details</strong> — if you create an account: your name, email address, and the qualification and subjects you select.",
                "<strong>Messages</strong> — anything you send us through the contact form, including your name, email address and the content of your message.",
                "<strong>Usage data</strong> — pages visited, resources opened, approximate location from your IP address, browser and device type.",
                "<strong>Cookie data</strong> — see our <a href=\"cookies.html\">cookie policy</a>.",
            ]),
        ]),
        ("How we use it", [
            ("list", [
                "To show you the resources for your course and remember your selection.",
                "To answer messages you send us.",
                "To understand which resources are used, so we know what to add next.",
                "To keep the site secure and prevent abuse.",
            ]),
            "We do not sell your data, and we do not use it to build advertising profiles.",
        ]),
        ("Our legal basis", [
            "Under UK GDPR we rely on: <strong>legitimate interests</strong> for running and improving the site "
            "and keeping it secure; <strong>consent</strong> for non-essential cookies and any marketing email, "
            "which you can withdraw at any time; and <strong>contract</strong> where you have an account with us.",
        ]),
        ("Who we share it with", [
            "We share data only with service providers who help us run the site — hosting, email delivery and "
            "analytics — and only what they need. They act on our instructions and cannot use your data for "
            "their own purposes.",
            "We may disclose data if the law requires it, or to protect our rights or the safety of users.",
        ]),
        ("How long we keep it", [
            ("list", [
                "Account data — while your account is open, then deleted within 6 months of closure.",
                "Contact form messages — up to 24 months.",
                "Analytics data — up to 26 months, in aggregated form where possible.",
            ]),
        ]),
        ("Your rights", [
            "You can ask us to give you a copy of your data, correct it, delete it, restrict or object to how we "
            "use it, or send it to another provider. Email "
            f"{COMPANY['privacy_email']} and we will respond within one month.",
            "If you are not satisfied with our response you can complain to the Information Commissioner's Office "
            "at ico.org.uk.",
        ]),
        ("Children and young people", [
            "Many of our users are school-age. We keep collection to a minimum and never require an account to "
            "access resources. If you are under 13, ask a parent or guardian before creating an account or "
            "sending us a message. If you believe a child has given us personal data without permission, "
            f"contact {COMPANY['privacy_email']} and we will delete it.",
        ]),
        ("Security", [
            "The site is served over HTTPS and access to personal data is limited to people who need it. "
            "No system is perfectly secure, so please use a strong, unique password for your account.",
        ]),
        ("Changes to this policy", [
            f"We update this policy when our practices change. The version above is dated {COMPANY['updated']}. "
            "Material changes will be announced on the site.",
        ]),
    ],
}

TERMS = {
    "slug": "terms",
    "title": "Terms and conditions",
    "intro": "These terms cover your use of Merit Study Resources. By using the site you accept them.",
    "sections": [
        ("About us", [
            f"{COMPANY['name']} is operated by {COMPANY['legal']} (company number {COMPANY['number']}). "
            f"You can reach us at {COMPANY['email']}.",
        ]),
        ("Using the site", [
            "The site is free to use and no account is needed to open resources. You may use the material for "
            "your own study, or — if you are a teacher — with your own students.",
        ]),
        ("Our resources and your licence", [
            "Revision notes, topic questions, tests, workbooks and worked solutions written by us are our "
            "copyright. You may download, print and share them for non-commercial educational use, with the "
            "source left intact.",
            ("list", [
                "You may not sell our material, or include it in a paid product or service.",
                "You may not republish it on another website or app, in whole or in part.",
                "You may not remove attribution or present our work as your own.",
            ]),
        ]),
        ("Exam board material", [
            "Past papers and mark schemes are the copyright of the relevant awarding body — AQA, Pearson "
            "Edexcel, OCR, Cambridge, WJEC/Eduqas and others. We link to or host them for study purposes only. "
            "We are not affiliated with, endorsed by, or connected to any awarding body.",
            "If you are a rights holder and want material removed, email "
            f"{COMPANY['email']} and we will act promptly.",
        ]),
        ("Accounts", [
            "You are responsible for keeping your password safe and for activity on your account. Tell us "
            "straight away if you think someone else is using it. We may suspend an account that is used to "
            "break these terms.",
        ]),
        ("Acceptable use", [
            ("list", [
                "Do not attempt to disrupt the site, bypass security, or scrape it at scale.",
                "Do not upload anything unlawful, offensive, or infringing.",
                "Do not use the site to impersonate anyone or misrepresent your connection to us.",
            ]),
        ]),
        ("Accuracy and results", [
            "We check our material carefully, but we cannot guarantee it is free of errors, complete, or fully "
            "current with a specification. Always check the awarding body's own specification and assessment "
            "materials. Using this site does not guarantee any particular grade or outcome.",
            f"If you spot a mistake, please tell us at {COMPANY['email']} — corrections help everyone.",
        ]),
        ("Links to other sites", [
            "Where we link elsewhere, we do not control that site and are not responsible for its content.",
        ]),
        ("Availability", [
            "We aim to keep the site available but may suspend it for maintenance or for reasons outside our "
            "control, without notice.",
        ]),
        ("Our liability", [
            "Nothing in these terms limits liability for death or personal injury caused by negligence, for "
            "fraud, or anything else that cannot be limited by law. Otherwise, to the extent permitted by law, "
            "we are not liable for indirect or consequential loss, lost data, or loss arising from reliance on "
            "the material on this site.",
        ]),
        ("Changes and governing law", [
            f"We may update these terms; the version above is dated {COMPANY['updated']}. These terms are "
            "governed by the law of England and Wales, and the courts of England and Wales have exclusive "
            "jurisdiction.",
        ]),
    ],
}

REFUND = {
    "slug": "refund",
    "title": "Refund policy",
    "intro": "Almost everything here is free. This policy covers the few things that are paid — printed "
             "workbooks and any paid digital download.",
    "sections": [
        ("Free resources", [
            "Past papers, revision notes, topic questions, tests and worked solutions on this site are free. "
            "There is nothing to refund, and we will never ask for card details to open them.",
        ]),
        ("Printed workbooks", [
            "Where you buy a printed workbook directly from us, you have 14 days from delivery to change your "
            "mind, and a further 14 days to return the item. It should be unused and in resaleable condition. "
            "We refund the purchase price and standard outbound delivery within 14 days of receiving the return.",
            "Return postage is yours to pay unless the item is faulty, damaged or not what you ordered.",
        ]),
        ("Faulty, damaged or wrong items", [
            f"Email {COMPANY['email']} within 30 days with your order number and a photo. We will replace the "
            "item or refund it in full, including postage both ways. This does not affect your statutory rights "
            "under the Consumer Rights Act 2015.",
        ]),
        ("Paid digital downloads", [
            "For a paid download, you agree that access begins immediately and the 14-day cancellation right "
            "ends once the file is downloaded. If a file is corrupt, will not open, or is not what was "
            "described, we will fix it or refund it.",
        ]),
        ("Books bought on Amazon", [
            "Workbooks bought through Amazon are sold by Amazon, so their returns process applies — start a "
            "return in <em>Your Orders</em>. We cannot refund an Amazon purchase directly, but tell us if "
            "something is wrong with the book itself so we can correct it.",
        ]),
        ("How to request a refund", [
            ("list", [
                f"Email {COMPANY['email']} with your order number and what went wrong.",
                "We reply within 2 working days.",
                "Approved refunds go back to the original payment method within 14 days.",
            ]),
        ]),
        ("Questions", [
            f"Anything not covered here, ask us at {COMPANY['email']} and we will sort it out.",
        ]),
    ],
}

COOKIES = {
    "slug": "cookies",
    "title": "Cookie policy",
    "intro": "Cookies are small files a site stores on your device. Here is what we use and how to turn "
             "the optional ones off.",
    "sections": [
        ("Why we use cookies", [
            "We keep cookies to a minimum: enough to remember your course selection and to understand which "
            "resources are being used. We do not use advertising cookies and we do not sell data to advertisers.",
        ]),
        ("What we set", [
            ("table",
             ["Cookie", "Type", "Purpose", "Expires"],
             [
                 ["msr_consent", "Essential", "Remembers your cookie choice", "12 months"],
                 ["msr_course", "Preferences", "Remembers your qualification, subject and exam board", "6 months"],
                 ["msr_session", "Essential", "Keeps you signed in during a visit", "When you close the browser"],
                 ["_ga / _ga_*", "Analytics", "Counts visits and pages viewed (Google Analytics)", "Up to 24 months"],
             ]),
            "Analytics cookies are only set if you accept them.",
        ]),
        ("Managing your choice", [
            "Use the cookie banner to accept or reject optional cookies. You can change your mind at any time "
            "by clearing this site's data in your browser, which brings the banner back.",
        ]),
        ("Browser controls", [
            "Every major browser lets you block or delete cookies in its settings — usually under Privacy or "
            "Site settings. Blocking essential cookies may stop parts of the site working, such as staying "
            "signed in.",
        ]),
        ("Third parties", [
            "Embedded content — for example a video — may set its own cookies. Those are controlled by the "
            "provider, and their own policies apply.",
        ]),
        ("Changes", [
            f"This policy was last updated on {COMPANY['updated']}. We will update it if the cookies we use "
            "change. See also our <a href=\"privacy.html\">privacy policy</a>.",
        ]),
    ],
}

LEGAL_PAGES = [PRIVACY, TERMS, REFUND, COOKIES]

# --------------------------------------------------------------------------
# FAQs — (category, [(question, answer_html)])
# --------------------------------------------------------------------------

FAQS = [
    ("Using the site", [
        ("Is everything really free?",
         "Yes. Every past paper, revision note, topic question, test, workbook and worked solution on this site "
         "is free to open and download. There is no paywall and no trial that expires."),
        ("Do I need an account?",
         "No. You can browse and download everything without signing up. An account only adds convenience — it "
         "remembers your course and saves resources you want to come back to."),
        ("How do I find resources for my course?",
         "Use the finder on the <a href=\"index.html\">homepage</a>: choose your qualification, subject and exam "
         "board, then <em>View resources</em>. Or start from the <a href=\"subjects.html\">subjects page</a> and "
         "narrow down from there."),
        ("Can teachers use these with a class?",
         "Yes. Teachers and tutors are welcome to print and share our own material with their students. Please "
         "leave the source on the page and do not sell it or put it behind a paywall."),
    ]),
    ("Resources and exam boards", [
        ("Which exam boards do you cover?",
         "AQA, Pearson Edexcel, OCR, Cambridge (CIE), WJEC/Eduqas and others depending on the subject. The exam "
         "board is shown on every resource, so check it matches what your school entered you for."),
        ("Are you connected to the exam boards?",
         "No. We are independent. Past papers and mark schemes remain the copyright of the awarding body and we "
         "provide them for study only. Always check the board's own specification as the definitive source."),
        ("How current is the material?",
         "We work from the current specification for each subject and add new papers after each exam series. "
         "Where a specification has changed, older papers are labelled so you know what still applies."),
        ("I found a mistake — what should I do?",
         "Please tell us. Use the <a href=\"contact.html\">contact form</a> with the resource name and the "
         "question number, and we will check and correct it."),
        ("Can you add my subject?",
         "Probably. Send a request through the <a href=\"subjects.html\">subjects page</a> and we will prioritise "
         "what people ask for most."),
    ]),
    ("Accounts", [
        ("How do I create an account?",
         "Go to <a href=\"register.html\">register</a> and give a name, email and password. That is all we ask for."),
        ("I have forgotten my password.",
         "Use the <em>Forgot password</em> link on the <a href=\"login.html\">sign-in page</a> and we will email "
         "you a reset link."),
        ("How do I delete my account?",
         "Email us and we will delete it and the data attached to it. See the "
         "<a href=\"privacy.html\">privacy policy</a> for what we hold and for how long."),
    ]),
    ("Downloads and printing", [
        ("What format are the files in?",
         "PDF, so they open on any device and print the same way everywhere."),
        ("A file will not open.",
         "Try downloading it rather than viewing it in the browser, and make sure your PDF reader is up to date. "
         "If it still fails, tell us which file and we will re-upload it."),
        ("Can I print the workbooks?",
         "Yes. They are designed to print double-sided on A4, with space to write."),
    ]),
    ("Tutoring and contact", [
        ("Do you offer tutoring as well?",
         "This site is the free resource library. For tuition, use the <a href=\"contact.html\">contact form</a> "
         "and we will point you in the right direction."),
        ("How quickly do you reply?",
         "Within two working days for most messages. Corrections to resources are usually faster."),
    ]),
]

# --------------------------------------------------------------------------
# Blog — sample posts
# --------------------------------------------------------------------------

POSTS = [
    {
        "slug": "past-papers-properly",
        "title": "How to use past papers properly (most students do it backwards)",
        "category": "Revision tips",
        "tint": "tint-mint",
        "icon": "file-earmark-text",
        "date": "24 August 2026",
        "read": "6 min read",
        "excerpt": "Doing a paper and checking the score tells you almost nothing. Here is the loop that "
                   "actually moves marks: attempt, mark honestly, redo, then re-attempt cold a week later.",
        "featured": True,
    },
    {
        "slug": "reading-mark-schemes",
        "title": "Reading a mark scheme like an examiner",
        "category": "Exams explained",
        "tint": "tint-sky",
        "icon": "list-check",
        "date": "17 August 2026",
        "read": "5 min read",
        "excerpt": "M1, A1, B1 and 'oe' are not decoration. Once you can read the notation you can see exactly "
                   "where marks are given and stop losing them for missing working.",
    },
    {
        "slug": "revision-timetable",
        "title": "A revision timetable that survives contact with a real week",
        "category": "Revision tips",
        "tint": "tint-cream",
        "icon": "calendar-week",
        "date": "10 August 2026",
        "read": "7 min read",
        "excerpt": "Colour-coded hour-by-hour plans collapse by Wednesday. Build around fixed points, leave "
                   "slack, and plan the week rather than the term.",
    },
    {
        "slug": "grade-boundaries-explained",
        "title": "GCSE grade boundaries explained — and why they move",
        "category": "Exams explained",
        "tint": "tint-lilac",
        "icon": "graph-up",
        "date": "3 August 2026",
        "read": "5 min read",
        "excerpt": "Boundaries are set after the exams, not before. Understanding why stops you panicking about "
                   "a hard paper and helps you read your mock results sensibly.",
    },
    {
        "slug": "foundation-or-higher",
        "title": "Foundation or Higher tier: how to decide",
        "category": "Parents",
        "tint": "tint-sage",
        "icon": "signpost-split",
        "date": "27 July 2026",
        "read": "6 min read",
        "excerpt": "A grade 5 on Foundation beats a grade 3 on Higher. What the tiers actually cover, who each "
                   "suits, and the questions to ask at parents' evening.",
    },
    {
        "slug": "revise-maths-without-notes",
        "title": "Six ways to revise maths when reading notes isn't working",
        "category": "Subject guides",
        "tint": "tint-blush",
        "icon": "calculator",
        "date": "20 July 2026",
        "read": "4 min read",
        "excerpt": "Maths is not a reading subject. Blank-page recall, worked-example fading and mixed practice "
                   "beat highlighting every time.",
    },
]

BLOG_CATEGORIES = ["All posts", "Revision tips", "Exams explained", "Subject guides", "Parents"]
