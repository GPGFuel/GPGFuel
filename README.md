## Challenge

Storing the public key of a PGP key pair in a Web Key Directory whenever the user can also access the email addresses associated with this key.


## What is GPGFuel?

GPGFuel is a set of tools that runs on your webserver that allows easy updating your domains 
WebKeyDirectory.

## What is GPGFuel not?

* GPGFuel is not providing the WebKeyDirectory. That is still handled by your webserver.
* GPGFuel is not interacting with your LDAP or other Directory-Service or database to retrieve public keys
* GPGFuel is not handling or providing any encryption, decryption verification or signature functionality.

## What is a Web Key Directory (WKD)?

"Web Key Directory" allows public keys to be easily obtained from a service provider 
URL directory via an HTTPS query. This greatly simplifies an important part of the 
processes involved in using email encryption, namely key exchange. The secure exchange 
of e-mails and files can thus be activated more easily by users and used - even in everyday
e-mail communication.

In contrast to the public key servers used to date, the integrated Web Key Directory 
only publishes authenticated e-mail addresses including the public key. Via the 
integrated WKD, the e-mail server of the respective provider becomes the authoritative and
reliable reference point for the correct public key of the respective e-mail address. This is because the public key and the e-mail address are firmly linked by a verification process, ideally via the explicit confirmation of the e-mail user himself. This means that confusion can be ruled out as far as possible.


## How does the Web Key Directory (WKD) work?

The major advantage of the WKD directory is the automation of the processes for obtaining
the correct public key for an email address. For the system to work, WKD must 
be supported by the user's e-mail program. Then the server and the e-mail program can 
automatically exchange and apply the public keys to encrypt the e-mails. The following 
steps are then performed in the background of the respective e-mail programs:

The sender's e-mail program queries a specific URL in the domain of the
recipient's e-mail service provider.

For the e-mail address "jane.doe@example.com" the corresponding URL could look like this
https://example.com/.well-known/openpgpkey/hu/xnq3qe6k38niuruhjisgg8q3gnk8k5cc

## Receive a signed email

In case once receives an email that is digitally signed, an email-client will contact the 
WebKey Directory to obtain the public key of the sender of the email. With that the 
signature can now be verified and should that not be possible due to an email that was
changed during transportation or because the key does not match the one that was used to 
sign the email then the user is notified that there is a mismatch and that the signature
is not valid.

## Sending an encrypted email
 
When one wants to send an encrypted email to someone the email-client will contact the WebKey
Directory to obtain the public keys of the receipients of the email. Those are then used to
encrypt the email per recipient so

The downloaded public key is also in both cases added to the local storage and will in
future directly be used without having to contact the WebKey Directory any more.

# What does WKD mean for e-mail users?

If WKD is integrated in both e-mail programs of the communication partners and is 
supported by the providers of both communication partners, it is easy to use once 
email encryption has been activated. The user selects the recipient of the e-mail. 
Subsequently, messages are automatically encrypted by default as soon as the e-mail
backend (GPG) finds the public keys of the communication partners in the local key 
store or in the Web Key Directory.

For a basic level of security, the user no longer needs to check the public key, 
nor does he or she need to manage the public key manually.

## Screenshots

## Installation

### Preparation

A WebKey Directory can be used in two different ways: Either directly from a webserver
serving the email-domain or from an openpgpkey-subdomain of the email-domain. So for
email addresses like jane.doe@example.com the email-domain would be example.com. So the
WebKey Directory is either accessible at https://example.com (direct access) or at 
https://openpgpkey.example.com. (advanced access)

#### Advanced Access

You will need a webserver that serves files from 
https://openpgpkey.example.com/.well-known/openpgpkey/example.com/hu/

#### Direct Access

You will need a webserver that serves files from 
https://example.com/.well-known/openpgpkey/hu/

#### General considerations

Those files need to be served with a Content-Type of `octet/binary`.
In addition you will need to send an `Access-Control-Allow-Origin` header with content `*` 
with each key.

You will also need to serve a `policy` file from the folder that contains your `hu` folder.

If you have that all set up you can check your setup at https://metacode.biz/openpgp/web-key-directory

## Email clients supporting WebKey Directory

This is a non-exclusive list. There might be more solutions. Feel free to drop us a line to
have your solution included in this list.

* Thunderbird (native) (Windows/MaoOS/Linux)
* KMail (Linux)
* Outlook with GppOL (Windows)
* Mailvelope (Browser extension for Chrome/Firefox/Edge)
* K9Mail (via OpenKeyChain) (Android)
* FairEmail (via OpenKeyChain) (Android)
* Apple Mail (with GPGMail) (MacOS)
* PGPro (iOS)
    
## Usage

Install composer dependencies
```bash
php composer.phar install
```

Copy the project environnement file
```bash
cp .env.dist .env
```

And set the proper configuration variables :

`APP_SECRET` should be a random generated string

`APP_URL` should be your current app location ( example : https://example.com)

### Mailer configuration

```bash
MAILER_HOST=smtp.example.com
MAILER_AUTH=true
MAILER_PORT=25
MAILER_USERNAME=noreply@example.com
MAILER_PASSWORD=AnAwesomePassword!
MAILER_FROM=noreply@example.com
MAILER_NAME=Example GPG Verification
```

### Storage Configuration
`TMP_PATH` is a temporary folder where you want to store temporary keys awaiting verification. It shoud not be accessible publicly on internet.

`WEBKEYDIRECTORY_PATH` is the path to your openphpkey well known folder.


```bash
TMP_PATH=/tmp/webkeydirectory/
WEBKEYDIRECTORY_PATH=/var/www/example.com/.well_known/openpgpkey/hu/
```
## Links

* [WebKey Directory description at the GPG website](https://wiki.gnupg.org/WKD)