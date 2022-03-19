## Challenge

Storing the public key of a PGP key pair in a Web Key Directory whenever the user can also access the email addresses associated with this key.


## What is GPGFuel?

## What is GPGFuel not?


## What is a Web Key Directory (WKD)?

"Web Key Directory" allows public keys to be easily obtained from a service provider URL directory via an HTTPS query. This greatly simplifies an important part of the processes involved in using email encryption, namely key exchange. The secure exchange of e-mails and files can thus be activated more easily by users and used - even in everyday e-mail communication.

In contrast to the public key servers used to date, the integrated Web Key Directory only publishes authenticated e-mail addresses including the public key. Via the integrated WKD, the e-mail server of the respective provider becomes the authoritative and reliable reference point for the correct public key of the respective e-mail address. This is because the public key and the e-mail address are firmly linked by a verification process, ideally via the explicit confirmation of the e-mail user himself. This means that confusion can be ruled out as far as possible.

## How does the Web Key Directory (WKD) work?

The major advantage of the WKD directory is the automation of the processes for obtaining the correct public key for the associated e-mail address. For the system to work, WKD must be supported by both the user's e-mail program and the e-mail service provider. Then the server and the e-mail program can automatically exchange and apply the public keys to encrypt the e-mails. The following steps are then performed in the background of the respective e-mail programs:

The sender's e-mail program queries a specific URL in the domain of the recipient's e-mail service provider.

For the e-mail address "max.muster@easy-gpg.de"
the corresponding URL could look like this
https://easy-gpg.de/.well-known/openpgpkey/hu/g8td9rsyatrazsoiho37j8n3g5ypp34h
 
If the public key for the recipient's mail address is available there, it is downloaded via HTTPS and stored locally.
The downloaded public key can now be used to encrypt mails to the recipient without any further action on the part of the user.
If another mail is sent encrypted to this recipient, the public key can be used directly from the local storage and does not have to be downloaded again.
What does WKD mean for e-mail users?

If WKD is integrated in both e-mail programs of the communication partners and is supported by the providers of both communication partners, it is easy to use once e-mail encryption has been activated. The user selects the recipient of the e-mail. Subsequently, messages are automatically encrypted by default as soon as the e-mail backend (GPG) finds the public keys of the communication partners in the local key store or in the Web Key Directory.

For a basic level of security, the user no longer needs to check the public key, nor does he or she need to manage the public key manually.

## Screenshots

## Installation

