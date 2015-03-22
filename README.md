Native API Examples
===================

Janrain's OAuth registration and authentication API endpoints have picked up the
nickname "Native API" since they were designed for use within *native* desktop
and mobile appliactions.

Using the Native API for web applications can offer a greater degree of control
over the user registration and authentication flows at the cost of the
convenience and simplicity of the
[Registration Javascript "widget"](http://developers.janrain.com/overview/registration/registration-overview/javascript-based-solution-for-websites/) .


Contents
--------

* [Prerequisites](#user-content-prerequisites)
* [Getting Started](#user-content-getting-started)
* [Examples](#user-content-examples)
    * [Social Registration](#user-content-social-registration)
    * [Social Sign In](#user-content-social-sign-in)
    * [Traditional Registration](#user-content-traditional-registration)
    * [Traditional Sign In](#user-content-traditional-sign-in)
    * [Social Merge Accounts](#user-content-social-merge-accounts)
    * [Traditional Merge Accounts](#user-content-traditional-merge-accounts)
    * [Account Linking](#user-content-account-linking)
    * [Edit Profile](#user-content-edit-profile)
    * [Forgot Password](#user-content-forgot-password)
    * [Verify Email](#user-content-verify-email)


Prerequisites
-------------

* Janrain Social Login (aka Engage) application
* Janrain Registration (aka Capture) application
* PHP web server or local environment (eg. LAMP,
  [MAMP](https://www.mamp.info/en/), [WAMP](http://www.wampserver.com/en/), etc.)


Getting Started
---------------

1. Create a new Janrain *Login* API client using the
[`/clients/add`](http://developers.janrain.com/rest-api/methods/api-client-configuration/clients/add-3/)
API call:

        curl -X POST \
        -d client_id=57yzx9cbyczcfs8jsakreh5a4ueq2ynj \
        -d client_secret=REDACTED \
        -d description='Native API examples login client' \
        -d features='["login_client"]' \
        https://YOUR_APP.janraincapture.com/clients/add

1. [Download the source code](https://github.com/JanrainMicah/janrain-native-api-examples/archive/master.zip)
   or fork and clone this repository.
2. Unzip the files into your web server root. For example:

        unzip janrain-native-api-examples-master.zip -d /var/www

3. Rename `config.example.php` to `config.php`.
4. Add the client ID and secret for login client your created in step 1 to the
`config.php` file:

        define('JANRAIN_LOGIN_CLIENT_ID', 'Your client ID goes here');
        define('JANRAIN_LOGIN_CLIENT_SECRET', 'Your client secret goes here');

5. Navigate to the examples folder in your web browser. Eg.
[`http://localhost/janrain-native-api-examples-master/`](http://localhost/janrain-native-api-examples-master/)


Examples
--------

### Social Registration
### Social Sign In
### Traditional Registration
### Traditional Sign In
### Social Merge Accounts
### Traditional Merge Accounts
### Account Linking
### Edit Profile
### Forgot Password
### Verify Email