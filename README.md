Upload Images
=================
Upload Images enables you to upload images in your images folder of your board. The ui folder is used for the images and is created automatically when enabling this extension. Copy imagepath simply by clicking and use it wherever you want to show your image. Be careful with deleting images as there is no check if the image is still used.

[![Build Status](https://travis-ci.org/ForumHulp/uploadimage.svg?branch=master)](https://travis-ci.org/ForumHulp/uploadimage)

## Requirements
* phpBB 3.1.0-dev or higher
* PHP 5.3.3 or higher

## Installation
You can install this extension on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:

1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/uploadimage/archive/master.zip).
2. Check out the existing of the folder `/ext/forumhulp/uploadimage/` in the root of your board folder. Create folders if necessary.
3. Copy the contents of the downloaded `upload-master` folder to `/ext/forumhulp/uploadimage/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Image`.
5. Click `Enable`.
6. Or use our ([Upload Extensions](https://github.com/ForumHulp/upload)).

Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0.

## Usage
### Upload Image
To upload images navigate in the ACP to `Customise -> Upload image`.
Choose your image(s) by clicking the add files button. The extension will upload your file(s) in the folder /images/ui.

### Delete image
To delete image(s) from the server simply click delete in image list.

## Update
1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/uploadimage/archive/master.zip).
2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Image` and click `Disable`.
3. Copy the contents of the downloaded `upload-master` folder to `/ext/forumhulp/uploadimage/`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Image` and click `Enable`.
5. Click `Details` or `Re-Check all versions` link to follow updates.

## Uninstallation
Navigate in the ACP to `Customise -> Extension Management -> Manage extensions -> Upload Image` and click `Disable`.

For permanent uninstallation click `Delete Data` and then you can safely delete the `/ext/forumhulp/uploadimage/` folder.
Or use our ([Upload Extensions](https://github.com/ForumHulp/upload)).

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - John Peskens (http://ForumHulp.com)