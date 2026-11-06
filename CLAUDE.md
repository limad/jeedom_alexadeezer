# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`alexadeezer` ("Alexa - Deezer") is a small, old Jeedom plugin (`require` 3.3.24, no daemon, 12 files) that exposes Deezer playback on Echo devices. It is a companion of the Alexa-Premium plugin. It cannot run standalone: PHP files `require` the core. There is no build step, test suite or i18n.

## Commands

- Syntax check: `php -l core/class/alexadeezer.class.php`.
- Manual testing in a running Jeedom only.

## Architecture

- Single class file `core/class/alexadeezer.class.php` (~580 lines): `alexadeezer extends eqLogic` + `alexadeezerCmd extends cmd`. Same skeleton as `alexaamazonmusic` / `alexaSmart` (`createNewDevice`, `hasCapaorFamilyorType`, `forcerDefaultCmd`, `updateCmd`, `toHtml`, `getWidgetTemplateCode`, `cron`).
- No `core/ajax` file: the UI (`desktop/php/alexadeezer.php`, `desktop/js/alexadeezer.js`, `desktop/modal/health.php`) works from core equipment pages.
- Web access: `core/class/.htaccess` and `plugin_info/.htaccess` are present (the latter uses `Require all denied` for `.php`).

## Repository conventions

Git repo `limad/jeedom_alexadeezer` (public, default branch `alpha`; `beta`/`stable`/`master` still hold the 2022 Sigalou code). On 2026-11-06 the copy running on jee79 was committed to `alpha`, and jee79 now installs this plugin from GitHub (update source `github`, branch `alpha`). Local clone on jee89: `ai_agents/PROJECTS_others/jeedom_alexadeezer`. Author `Limad44`, license AGPL-3.0 (`LICENSE`).
