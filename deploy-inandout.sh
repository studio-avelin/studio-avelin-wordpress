#!/usr/bin/env bash
set -euo pipefail

# Deploy the static "In & Out with us" page (inandout/) to IONOS, so it is
# served at https://studio-avelin.com/inandout/. The folder sits next to
# WordPress in the web root; WordPress' rewrite rules skip existing
# directories, so no .htaccess change is needed.
#
# Uses the built-in sftp + expect like deploy.sh (no lftp needed).
# Required before running:
#   source ~/.studio-avelin-deploy-env   (sets IONOS_SFTP_USER / IONOS_SFTP_PASSWORD)

cd "$(dirname "${BASH_SOURCE[0]}")"

REMOTE_HOST="${IONOS_SFTP_HOST:-access-5020051294.webspace-host.com}"
REMOTE_USER="${IONOS_SFTP_USER:?Set IONOS_SFTP_USER before deploying.}"
: "${IONOS_SFTP_PASSWORD:?Set IONOS_SFTP_PASSWORD before deploying.}"
REMOTE_DIR="${IONOS_SFTP_REMOTE_ROOT:-clickandbuilds/StudioAvelin}/inandout"
LOCAL_DIR="inandout"

[[ -f "${LOCAL_DIR}/index.html" ]] || { echo "Missing ${LOCAL_DIR}/index.html" >&2; exit 1; }

FILES=()
while IFS= read -r -d '' f; do
  FILES+=("${f#${LOCAL_DIR}/}")
done < <(find "$LOCAL_DIR" -type f ! -name '.DS_Store' -print0)

echo "Deploying ${#FILES[@]} files from ${LOCAL_DIR}/ to ${REMOTE_DIR}/ ..."

expect -f - "$REMOTE_USER" "$REMOTE_HOST" "$REMOTE_DIR" "$LOCAL_DIR" "${FILES[@]}" <<'EXPECT'
set timeout 60

set remote_user [lindex $argv 0]
set remote_host [lindex $argv 1]
set remote_dir  [lindex $argv 2]
set local_dir   [lindex $argv 3]
set files       [lrange $argv 4 end]

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

# Create the target folder and any subfolders (already existing is fine).
set dirs [list $remote_dir]
foreach file $files {
  set d [file dirname $file]
  if {$d ne "."} { lappend dirs "$remote_dir/$d" }
}
foreach directory [lsort -unique $dirs] {
  send -- "mkdir $directory\r"
  wait_for_prompt "creating $directory" 1
}

# Upload under a temporary name, then rename over the live file.
foreach file $files {
  send -- "put $local_dir/$file $remote_dir/$file.uploading\r"
  wait_for_prompt "upload of $file"
  send -- "rename $remote_dir/$file.uploading $remote_dir/$file\r"
  wait_for_prompt "rename of $file"
}

send -- "bye\r"
expect eof
EXPECT

echo "Done: https://studio-avelin.com/inandout/"
