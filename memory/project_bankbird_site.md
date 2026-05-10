---
name: BankBird public website
description: Public marketing/docs site added to the BankBird accounting app
type: project
---

Added a full public website to the BankBird Laravel app (May 2026) with four pages:
- `/` — Landing/sales page with hero, features, how-it-works, privacy section, tech stack
- `/install` — Step-by-step installation guide (Dutch)
- `/docs` — Developer documentation: architecture, models, services, workflows
- `/demo` — Full demo with mock UI previews of all screens

**Why:** User wanted an online presence to showcase the app and help others install it from the GitHub repo.

**How to apply:** Pages live in resources/views/ (welcome.blade.php, install.blade.php, docs.blade.php, demo.blade.php) and share resources/views/layouts/public.blade.php. Routes are in routes/web.php. Tailwind CSS is in resources/css/app.css (requires @import "tailwindcss"). Served at http://bankbird.test via Herd.
