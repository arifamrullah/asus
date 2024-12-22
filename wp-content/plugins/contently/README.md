# Wordpress integration with Contently

### Packaging
1. Update the version number in ```index.php```
2. Run ```./bin/package```
3. Upload the new package to AWS S3 in ```integrations.contently.com:wordpress/releases```
  - _Be sure to change the persmissions of the file so it's publically accessible to read (but not write)_
4. Update the ```download_url``` and ```version``` in ```integrations.contently.com:wordpress/release.json```
