<p align="center"><img width="200" src="./branding/raw.png" alt="Raspberry Manager Logo"></p>

# Raspberry Manager

A webpage to manage your Raspberry Pi.
Purely written in PHP without any dependencies.

## Get started

1. Clone the repository in your webroot:

   ```sh
   git clone https://github.com/fussel178/raspberry-manager /var/www/raspberry-manager
   ```

2. Check out the latest release tag:

   ```sh
   git checkout v0.1.0
   ```

3. Copy the sudo configuration to the sudoers configuration directory:

   ```sh
   sudo cp meta/20-http-raspberry-manager /etc/sudoers.d/
   ```

   > **Note:** This configuration allows passwordless usage of some system critical commands.

4. Copy the sample configuration and adapt it to your needs:

   ```sh
   cp config.sample.php config.php
   ```

5. Finished!

## Packaged controllers

- System Controller (Reboot, Poweroff)
- Services Controller (manage systemd via the UI)
- Network Controller (displays some information about network interfaces on the machine)
- Remote Access Controller (renders information on how to connect to the machine)

## Hacking Raspberry Manager

Raspberry is a really simple PHP project and therefore easy to extend. Every card on the webpage is handled by a "controller".
The controller must handle incoming requests and render a webpage after handling the requests.

### Changing styles

Raspberry Manager uses [mini.css](https://minicss.org/) as "of-the-shelf" styling method. (with some tweaks and fixes)
You can use a different style set based on [mini.css](https://minicss.org/) generated with their [style generator](https://minicss.org/flavors).

If you created your style set, copy it in the `styles` folder and register it in the `index.php` in the head section. (see examples there)

Some predefined styles are already included. You can try them out by commenting in and out the right styles in the `index.php` head section.

### Writing controllers

A controller must extend the `Controller.php` model.
This inherits the override of the `getId`, `getTitle`, `getKeys`, `handle` and `render` method.

#### `getId`

Returns the unique id of the controller in the project.

#### `getTitle`

Returns the human-readable title of the controller.

#### `getKeys`

Returns an array that holds the elements the controller wants to receive in his `handle` method.

#### `handle`

Receives the predefined arguments in an array. The handler gets called before the `render` method.
Here the controller can handle the incoming request, make system calls, register something, etc.

#### `render`

Must return a valid HTML string.
This method gets called, when all requests have been handled and the webpage is built.

Every controller receives it's own space in a card component.

## About

Made with [mini.css](https://minicss.org/).
