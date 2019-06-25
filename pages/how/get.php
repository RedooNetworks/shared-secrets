<?php

  # prevent direct access
  if (!defined("SYS11_SECRETS")) { die(""); }

  # define page title
  define("PAGE_TITLE", "How does this service work?");

  # include header
  require_once(ROOT_DIR."/template/header.php");

  # prevents cache hits with wrong CSS
  $cache_value = md5_file(__FILE__);

  # handle indentation within shell command
  $indentation = "";
  $space_count = 64-strlen(SECRET_SHARING_URL);
  if (0 < $space_count) {
    $indentation = str_repeat(" ", $space_count);
  }

?>

  <h2>Eine kurze Beschreibung, wie dieser Dienst funktioniert.</h2>
  <p>Die Verschlüsselung bassiert auf einer GPG Verschlüsselung. Wenn Sie einen neuen sicheren Link generieren, dann wird das Geheimnis selbst via GPG verschlüsselt. Das Ergebnis dieser Verschlüsselung ist eine URL-sichere Version des Geheimnis. Wenn der geheime Link aufgerufen wurd, wird diese sichere URL wieder per GPG entschlüsselt und auf der Webseite angezeigt. Zusätzlich wird ein unwiederherstellbarerer Fingerabdruck auf dem Server abgelegt, damit das Geheimnis nur einmalig entschlüsselt werden kann. Dieser Fingerabdruck enthält das Geheimnis nicht.<br />
     <br />
     Sie können einen eigenen Secret Sharing link mit folgenden Schritten erstellen und sind komplett unabhängig unseres Dienstes.</p>

  <h3>Get korrekten öffentlichen Schlüssel holen.</h3>
  <p>Als erstes müssen Sie unseren öffentlichen Schlüssel laden, welcher zum Verschlüsseln benötigt wird und das Geheimnis selbst nicht entschlüsseln kann:<br/>
     <pre>gpg --recv-keys --keyserver "hkps://keyserver.syseleven.de/" "<?php print(htmlentities(GPG_KEY_FINGERPRINT)); ?>"</pre></p>

  <h3>Das Geheimnis verschlüsseln.</h3>
  <p>Um einen aufrufbaren Link zu erstellen, müssen Sie die folgenden Schritte durchführen:
     <ol>
       <li>das Geheimnis per GPG verschlüsseln</li>
       <li>Den verschlüsselten Text über Base64 kodieren</li>
       <li>Zeilenumbrüche entfernen</li>
       <li>URL-sichere Kodierungen ersetzen:
           <ul>
             <li>entferne = Zeichen</li>
             <li>ersetze "+" mit "-"</li>
             <li>ersetze "/" mit "_"</li>
           </ul></li>
       <li>die URL unseres Dienstes voranstellen, damit die URL entschlüsselt werden kann. Sie selbst können das Geheimnis nicht entschlüsseln.</li>
     </ol>
     <br />
     Alle diese Schritte können über folgende Shell Kommandos durchgeführt werden:<br />
     <pre>echo "geheimnis"                                                                     | # the secret you want to share
gpg --recipient "<?php print(htmlentities(GPG_KEY_FINGERPRINT)); ?>" --output - --encrypt - | # encrypt the secret via GPG
openssl base64                                                                    | # Base64 encode the encrypted secret
tr -d "\n"                                                                        | # remove line breaks
tr -d "="                                                                         | # remove equation signs
tr "+" "-"                                                                        | # replace "+" with "-"
tr "/" "_"                                                                        | # replace "/" with "_"
awk '{print "<?php print(htmlentities(SECRET_SHARING_URL)); ?>" $0}'<?php print($indentation); ?> # prepend secret sharing URL</pre></p>

  <h3>Oder..</h3>
  <p>... Sie nutzen unseren <a href="/">"Teile ein Geheimnis"</a> Dienst.</p>

<?php
  if (ENABLE_PASSWORD_PROTECTION) {
?>
  <h2>Eine kurze Erklärung zur Passwortverschlüsselung.</h2>
  <p>Wenn Sie die Passwortverschlüsselung nutzen, wird das Geheimnis selbst lokal im Browser über AES im GCM Mode verschlüsselt. Der Schlüssel wird vom eingegeben Passwort abgeleitet und um einen dynamischen Teil (Salt) über den PBKDF2 Algorithmus ergänzt. Der dynamische Teil wird dem Geheimnis vorangestellt und beeinträchtigt die Sicherheit nicht. Er ist notwendig, um eine Komplexität des Passwortes zu gewährleisten. Die Verschlüsselung erfolgt komplett auf Client Seite im Browser. Bitte beachten Sie, dass ein kompromitierter Server, verwundbaren Code ausliefern könnte. Wenn Sie dem Server nicht vertrauen, verschlüssel Sie das Geheimnis vorab lokal auf Ihrem Computer.
<?php
  }
?>

<?php

  # include header
  require_once(ROOT_DIR."/template/footer.php");

?>
