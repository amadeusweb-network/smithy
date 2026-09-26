## Installation on Mobile (Android)

DIV-LARGELIST

1. **Git Client** - (from Drive APK) - [PocketGit](https://drive.google.com/file/d/1L2yCUxSk-M3Lpy0KLyp72ZKrDJMdEJJ2/view?usp=drive_link).
1. **AWebServer** - [install](https://play.google.com/store/apps/details?id=com.sylkat.apache) - no url rewriting, but this is taken care of. [Document Root](https://builder.amadeusweb.com/assets/docs/mobile-web-server.jpg) MUST be /sdcard/Magique. Port can be 80 or 8080 - its fine.
1. **Obsidian.md** - [install](https://play.google.com/store/apps/details?id=md.obsidian) - for markdown file editing, note taking etc.
1. **File and PHP Editor** - (from Drive / APK) - [ES File Explorer](https://drive.google.com/file/d/1ncFu2G5tq-R0ndp1tjtMiN7BNtNPOeda/view?usp=drive_link)

DIV-CLOSE

---

## Setup Process

DIV-LARGELIST

1. **Theme assets** automatically loaded from live site (hosting), not needed to extract zip on phone.
1. Use Android's "My Files" or "ES File Explorer" to create **/sdcard/Magique**.
1. Go to PocketGit and create a "Project" and clone it. Configure Project Name "Spring" with cloneUrl (.git) and local path (Magique) as
	1. https://github.com/joyfulearth/spring.git
	1. /sdcard/Magique/spring
	1. same relative path to Magique as ./data/site.tsv > local-url
1. Open A WebServer and choose /sdcard/Magique as "DocumentRoot". Port can remain 8080. Tap "Service > Start" and wait for the Ad / Status which says "Running" in Green.
1. Visit [localhost:8080/spring/](https://localhost:8080/spring/) in the mobile browser.

DIV-CLOSE

---

## Notes and TODOs

* This needs to be done in version 9.2, but:
 Dawn > Admin > [Git Manager](http://localhost/dawn/admin/manage/) will have repos listed and mobile clone paths for quick copy paste.
