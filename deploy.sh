#!/usr/bin/env bash
set -euo pipefail

# Deploy the maintained Studio Avelin child-theme files to IONOS.
# Required before running:
#   export IONOS_SFTP_USER='...'
#   read -rs 'IONOS_SFTP_PASSWORD?IONOS-Passwort: '
#   export IONOS_SFTP_PASSWORD

REMOTE_HOST="${IONOS_SFTP_HOST:-access-5020051294.webspace-host.com}"
REMOTE_USER="${IONOS_SFTP_USER:?Set IONOS_SFTP_USER before deploying.}"
: "${IONOS_SFTP_PASSWORD:?Set IONOS_SFTP_PASSWORD before deploying.}"
REMOTE_DIR="${IONOS_SFTP_REMOTE_DIR:-clickandbuilds/StudioAvelin/wp-content/themes/studio-avelin-child}"
LOCAL_DIR="${IONOS_LOCAL_DIR:-studio-avelin-child}"
BACKUP_DIR="${IONOS_BACKUP_DIR:-.deploy-backups/$(date +%Y%m%d-%H%M%S)}"

FILES=(
  "style.css"
  "theme.json"
  "front-page.php"
  "functions.php"
  "404.php"
	"single.php"
	"single-experiment.php"
	"page-experiments.php"
	"page-about-me.php"
	"page-services.php"
	"page-contact.php"
	"page-datenschutzerklaerung.php"
	"page-impressum.php"
	"page-work.php"
	"page-work-hawaiimassage.php"
	"page-work-monroe-toyparty-landingpage.php"
	"page-work-baeckerei-curfs.php"
	"page-work-stan.php"
	"page-work-stat.php"
	"page-work-stau.php"
	"assets/img/favicons/favicon.svg"
	"assets/img/favicons/favicon.ico"
	"assets/img/favicons/favicon-16x16.png"
	"assets/img/favicons/favicon-32x32.png"
	"assets/img/favicons/favicon-48x48.png"
	"assets/img/favicons/apple-touch-icon.png"
	"assets/img/favicons/android-chrome-192x192.png"
	"assets/img/favicons/android-chrome-512x512.png"
	"assets/img/favicons/site.webmanifest"
	"assets/img/portrait.jpg"
	"assets/img/about/michael.jpg"
	"assets/img/og-default.png"
	"assets/img/project-portfolio-visual.svg"
	"assets/img/work/hawaiimassage/hero.jpg"
	"assets/img/work/hawaiimassage/lomi.jpg"
	"assets/img/work/hawaiimassage/aromaoel.jpg"
	"assets/img/work/hawaiimassage/hotstone.jpg"
	"assets/img/work/monroe/hero.jpg"
	"assets/img/work/baeckerei-curfs/hero.jpg"
	"assets/img/work/baeckerei-curfs/brood.jpg"
	"assets/img/work/baeckerei-curfs/vlaai.jpg"
	"assets/img/work/baeckerei-curfs/winkel.jpg"
	"parts/sa-header.php"
	"parts/sa-project-note.php"
  "parts/sa-footer.php"
	"patterns/datenschutz.php"
	"patterns/impressum.php"
  "inc/sa-journal.php"
  "journal/post-cover.php"
  "journal/template-card.php"
  "journal/header.php"
  "journal/footer.php"
	"assets/css/sa-fonts.css"
	"assets/css/sa-base.css"
  "assets/css/sa-journal.css"
	"assets/css/home.css"
	"assets/css/pages.css"
	"assets/js/home.js"
  "assets/js/sa-journal.js"
	"assets/fonts/poppins-300-latin.woff2"
	"assets/fonts/poppins-300-latin-ext.woff2"
	"assets/fonts/poppins-400-latin.woff2"
	"assets/fonts/poppins-400-latin-ext.woff2"
	"assets/fonts/poppins-500-latin.woff2"
	"assets/fonts/poppins-500-latin-ext.woff2"
	"assets/fonts/poppins-600-latin.woff2"
	"assets/fonts/poppins-600-latin-ext.woff2"
	"assets/fonts/raleway-latin.woff2"
	"assets/fonts/raleway-latin-ext.woff2"
)

# Optional: deploy only the files given as arguments (paths relative to the theme),
# e.g. ./deploy.sh parts/sa-project-note.php assets/css/home.css
if [[ $# -gt 0 ]]; then
  FILES=("$@")
fi

for file in "${FILES[@]}"; do
  [[ -f "${LOCAL_DIR}/${file}" ]] || {
    echo "Missing deployment file: ${LOCAL_DIR}/${file}" >&2
    exit 1
  }
done

mkdir -p "${BACKUP_DIR}/parts" "${BACKUP_DIR}/patterns" "${BACKUP_DIR}/assets/css" "${BACKUP_DIR}/assets/img" "${BACKUP_DIR}/assets/js"
echo "Uploading ${#FILES[@]} files. New files (favicons, new work pages, style.css, theme.json) are not backed up because they do not exist on the server yet."
echo "Deploying ${#FILES[@]} child-theme files to IONOS..."

expect -f - "$REMOTE_USER" "$REMOTE_HOST" "$REMOTE_DIR" "$LOCAL_DIR" "$BACKUP_DIR" "${FILES[@]}" <<'EXPECT'
set timeout 60

set remote_user [lindex $argv 0]
set remote_host [lindex $argv 1]
set remote_dir  [lindex $argv 2]
set local_dir   [lindex $argv 3]
set backup_dir  [lindex $argv 4]
set files       [lrange $argv 5 end]

proc wait_for_prompt {context {allow_failure 0}} {
  expect {
    -re "(?i)(permission denied|couldn't|not found|no such file)" {
      puts stderr "$context failed"
      exit 1
    }
    -re "(?i)failure" {
      if {$allow_failure} {
        exp_continue
      }
      puts stderr "$context failed"
      exit 1
    }
    "sftp>" { return }
    timeout { puts stderr "$context timed out"; exit 1 }
    eof { puts stderr "Connection closed during $context"; exit 1 }
  }
}

spawn sftp -o StrictHostKeyChecking=accept-new -- "${remote_user}@${remote_host}"
expect {
  -re "(?i)password:" { send -- "$env(IONOS_SFTP_PASSWORD)\r" }
  timeout { puts stderr "Password prompt timed out"; exit 1 }
  eof { puts stderr "Connection closed before authentication"; exit 1 }
}
wait_for_prompt "authentication"

foreach file [list "style.css" "front-page.php" "functions.php" "single.php" "single-experiment.php" "page-experiments.php" "page-about-me.php" "page-services.php" "page-datenschutzerklaerung.php" "page-impressum.php" "page-work.php" "page-work-stan.php" "page-work-monroe-toyparty-landingpage.php" "parts/sa-header.php" "parts/sa-project-note.php" "parts/sa-footer.php" "patterns/datenschutz.php" "patterns/impressum.php" "assets/img/portrait.jpg" "assets/img/project-portfolio-visual.svg" "assets/css/home.css" "assets/css/pages.css" "assets/css/sa-base.css" "assets/js/home.js"] {
  send -- "get $remote_dir/$file $backup_dir/$file\r"
  wait_for_prompt "backup of $file"
}

foreach directory [list \
  "$remote_dir/inc" \
  "$remote_dir/journal" \
  "$remote_dir/parts" \
	"$remote_dir/patterns" \
  "$remote_dir/assets" \
  "$remote_dir/assets/css" \
  "$remote_dir/assets/fonts" \
  "$remote_dir/assets/img" \
  "$remote_dir/assets/img/favicons" \
  "$remote_dir/assets/img/about" \
  "$remote_dir/assets/img/work" \
  "$remote_dir/assets/img/work/hawaiimassage" \
  "$remote_dir/assets/img/work/monroe" \
  "$remote_dir/assets/img/work/baeckerei-curfs" \
  "$remote_dir/assets/js"] {
  send -- "mkdir $directory\r"
  wait_for_prompt "creating $directory" 1
}

foreach file $files {
  send -- "put $local_dir/$file $remote_dir/$file\r"
  wait_for_prompt "upload of $file"
}

send -- "bye\r"
expect eof
EXPECT

echo "Child-theme deployment completed successfully."
echo "Previous site files saved in: ${BACKUP_DIR}"
