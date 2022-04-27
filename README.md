# This is really bad code

However, if you want a simple way to inject raw emails into a SMTP server,
that ALSO honours all the SMTP features offered by PHPMailer, this is your
toy.

## Installation

    composer require xrobau/smtphack

## Usage

    use xrobau\SMTPHack;

    $from = 'xrobau@example.com';
    $to = 'fred@example.com';
    $hack = new SMTPHack($from, $to);
    $smtp = $hack->getSmtp('helo.hostname');
    $errors = $smtp->getError();
    // If this is running in a phpunit test, make sure there's nothing in errors
    $this->assertEmpty($errors['error']);
    $testemail = file_get_contents(__DIR__ . '/TestEmail.eml');
    $hack->data($testemail);

# Debugging

The code is really simple, and just leverages a few public functions of the PHPMailer
codebase to inject the raw email, without needing all of the rendering and encoding
features that PHPMailer provides.

I suggest you follow the code flow in PHPMailer itself if you want to debug things
further!

# Copyright

Copyright (C) 2022 by Rob Thomas <xrobau@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

