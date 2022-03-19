Zielgruppe: Admin

## Challenge

Storing the public key of a PGP key pair in a shared directory whenever the user can also access the email addresses associated with the key pair.

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

- Screenshots
- Installation
- 







## Welcome to GitHub Pages

You can use the [editor on GitHub](https://github.com/GPGFuel/GPGFuel/edit/main/docs/index.md) to maintain and preview the content for your website in Markdown files.

Whenever you commit to this repository, GitHub Pages will run [Jekyll](https://jekyllrb.com/) to rebuild the pages in your site, from the content in your Markdown files.

### Markdown

Markdown is a lightweight and easy-to-use syntax for styling your writing. It includes conventions for

```markdown
Syntax highlighted code block

# Header 1
## Header 2
### Header 3

- Bulleted
- List

1. Numbered
2. List

**Bold** and _Italic_ and `Code` text

[Link](url) and ![Image](src)
```

For more details see [Basic writing and formatting syntax](https://docs.github.com/en/github/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax).

### Jekyll Themes

Your Pages site will use the layout and styles from the Jekyll theme you have selected in your [repository settings](https://github.com/GPGFuel/GPGFuel/settings/pages). The name of this theme is saved in the Jekyll `_config.yml` configuration file.

### Support or Contact

Having trouble with Pages? Check out our [documentation](https://docs.github.com/categories/github-pages-basics/) or [contact support](https://support.github.com/contact) and we’ll help you sort it out.
