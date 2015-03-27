<html>
    <head>
        <title>Janrian Native API</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <img src="img/janrain-logo.png" class="logo">
        <h1>Native API Examples</h1>
        <div class="content">
            <ul>
                <li>
                    <a href="traditional-registration/">Traditional
                    Registration</a>
                    <div>
                    <small>Uses the <code>/oauth/register_native_traditional</code>
                    API call to perform a tradtidional registration.</small>
                    </div>
                </li>
                <li>
                    <a href="traditional-sign-in/">Traditional Sign In</a>
                    <div>
                    <small>Uses the <code>/oauth/auth_native_traditional</code>
                    API call to perform a tradtidional sign in.</small>
                    </div>
                </li>
                <li>
                    <a href="traditional-merge/">Traditional Merge</a>
                    <div>
                    <small>Uses the <code>/oauth/auth_native</code> and the
                    <code>/oauth/auth_native_traditional</code> API calls to
                    merge a social account with an existing traditional
                    account.</small>
                    </div>
                </li>
                <li>
                    <a href="social-registration/">Social Registration</a>
                    <div>
                    <small>Authenticates with Janrain's social authentication
                    service. Then, uses the <code>/oauth/auth_native</code> to
                    to check the status of the email address and the
                    <code>/oauth/register_native</code> API calls to
                    register a user.</small>
                    </div>
                </li>
                <li>
                    <a href="social-sign-in/">Social Sign In</a>
                    <div>
                    <small>Authenticates with Janrain's social authentication
                    service. Then, uses the <code>/oauth/auth_native</code> to
                    to check the status of the email address then hands back
                    an access token if sign in is permitted.</small>
                    </div>
                </li>
                <li>
                    <a href="social-merge/">Social Merge</a>
                    <div>
                    <small>Uses the <code>/oauth/auth_native</code> API
                    call twice to merge a social account with an existing 
                    social account.</small>
                    </div>
                </li>
                <li>
                    <a href="edit-profile/">Edit Profile</a>
                    <div>
                    <small>Uses the <code>/oauth/update_profile_native</code> 
                    API call to update a user profile.</small>
                    </div>
                </li>
                <li>
                    <a href="account-linking/">Account Linking</a>
                    <div>
                    <small>Uses the <code>/oauth/link_account_native</code>
                    and <code>/oauth/unlink_account_native</code> API calls
                    to link/unlink additional social accounts to a user
                    profile.</small>
                    </div>
                </li>
                <li>
                    <a href="forgot-password/">Forgot Password</a>
                    <div>
                    <small>Uses the <code>/oauth/forgot_password_native</code>
                    API call to send a user an email with a link to change their
                    password. Password is then changed using the
                    <code>/oauth/token</code> and
                    <code>/oauth/update_profile_native</code> API calls.</small>
                    </div>
                </li>
            </ul>
        </div>
    </body>
</html>