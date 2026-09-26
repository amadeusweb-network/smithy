First, ask for, read and agree to the

 * Terms
 * Spirit
 * Notices

---

> In this page, we will learn to install and get localhost running (laptop / desktop / mobile)

---

## 1. Setup Folder & Programs

DIV-LARGELIST

1. Create Folder: `D:\Work\` and download these installer files to ./Setups
1. Install [Git](https://git-scm.com/download/win), [TortoiseGit](https://tortoisegit.org/download/), [Apache](https://www.apachefriends.org/) <sup>1</sup> and [VSCode](https://code.visualstudio.com/download).
1. Additionally, [BeyComp](https://www.scootersoftware.com/download.php) or [PSPad](https://pspad.com/en/) may come in handy.
1. For uploading (delta only) to FTP, I've been [using this](%url%utilities/#ftp-uploader) which I wrote in 2007.

DIV-CLOSE

---

## Install and Configure Server

DIV-LARGELIST

1. Install Xampp (Windows + Apache + PHP) to `D:\Work\xampp` - MySql not needed for JoyfulEarth at all.
1. Run "xampp-control.exe" as admin and change the httpd.conf file
1. Change the DocumentRoot from `D:\Work\xampp\htdocs` to `D:\Work\public_html`
1. Tick the checkbox to allow Apache to be installed as a service. Also click run (row should hae a green lael saying running on port 80).
1. Clone [spring from github](https://github.com/amadeus-web/spring) using tortoise git into public_html.
1. Visit [localhost/spring/](http://localhost/spring/) in the browser - it should show the amadeus9 site content but broken (see #3 - theme assets setup below).
1. Visit [repos](http://localhost/spring/repos/) to clone other parts of the federated network. Needs you to run ./spring/network/_setup.bat

DIV-CLOSE

> In 2024, we had [v6.5.x](https://bitbucket.org/amadeusweb/amadeus/src/master/learning/how-to/setup-on-your-machine.md).

---

## 3. Extract Theme Assets

DIV-LARGELIST

1. Navigate to `D:\Work\public_html\spring\themes\canvas\`
1. Run `01--install-theme.bat` - do this everytime the theme assets are changed, renaming the old assets folder (in case it has pending changes etc).
1. Visit localhost/spring/ again, it should be working (network tab shows all assets loaded).

DIV-CLOSE
