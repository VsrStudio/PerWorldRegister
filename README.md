# PerWorldRegister

A PocketMine-MP plugin for managing player registration and login per world.

## Features
- Requires players to log in or register when entering specific worlds.
- Ensures security by restricting access to protected worlds.
- Easy-to-use login and registration forms.

## Requirements
- **PocketMine-MP** latest version (API 5).

## Installation
1. Download this plugin.
2. Extract the ZIP file and move the `PerWorldRegister` folder into your server's `plugins` directory.
3. Restart your PocketMine-MP server.

## Configuration
1. Open the `Main.php` file to set the list of protected worlds.
   ```php
   private array $protectedWorlds = ["world1", "world2"];
