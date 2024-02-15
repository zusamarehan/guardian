# Verifying Desktop sign-in via Mobile app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rehankanak/guardian.svg?style=flat-square)](https://packagist.org/packages/rehankanak/guardian)
[![Total Downloads](https://img.shields.io/packagist/dt/rehankanak/guardian?style=flat-square)](https://packagist.org/packages/rehankanak/guardian)

This Laravel package helps your application to verify a user's sign-in on a desktop browser via a mobile app. 
It works by generating a set of options, to which the user responds via the mobile app. If the user responds correctly, then the sign-in is verified and can be authorized. 

We have the following **GuardingType** in our package
- **INPUT**: The user inputs a code, into the mobile app.
- **PRESS**: The users presses a code, into the mobile app. 
- **APPROVE/DENY**: The user approves or denies the sign-in request, via the mobile app.

### The package provides the following routes:

- `POST /api/guardian/generate`
  - This route is used to generate a Guardian for the user to respond to.
- `POST /api/guardian/respond`
  - This route is used to respond to the Guardian via the Mobile app.
- `POST /api/guardian/status` 
  - This route is used to verify the user's response and authorize the sign-in.

## The Flow: 

## Desktop
1. When the user tries to sign-in on the desktop, and when the user credentials are verified, generate a Guardian for the user to respond to. 
   - Use the `POST /api/guardian/generate` route to generate a Guardian, with the users `uuid`
   - Once, the guardian is generated, trigger a notification to the user with the **GuardianType** and the **GuardianOption** obtained in the previous step.
2. Poll the `POST /api/guardian/status` route to check if the user has responded to the Guardian, this can give you three types of results 
   - **-1**: The user has not responded yet
   - **0**: The user has responded, with incorrect response
   - **1**: The user has responded, with the correct response 
3. Based on the Status, you can either authorize the sign-in or ask the user to respond again or generate a fresh guardian.

## Mobile
- Show a UI to the user, based on the **GuardianType** and **GuardianOption**
  - **INPUT**: Show a text input to the user, to input the code
  - **PRESS**: Show a list of codes to the user, to press the right code
  - **APPROVE/DENY**: Show two buttons to the user, to approve or deny the sign-in request
- When the user responds, use the `POST /api/guardian/respond` route to send the response to the server.

## Installation

You can install the package via composer:

```bash
composer require rehankanak/guardian
```

## Contributing

This is a community driven package. If you find any errors, please create a pull request with the fix, or at least open an issue.

## Testing

```bash
composer test
```

## Credits

- [Rehan Kanak](https://github.com/zusamarehan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
