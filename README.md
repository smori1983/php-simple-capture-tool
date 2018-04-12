# simple-capture-tool

## Browser automation tools

- [Selenium Standalone Server](https://www.seleniumhq.org/download/)
- [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads)
- [PhantomJS](http://phantomjs.org/download.html)

## Selenium Standalone Server + ChromeDriver

Put `Chromedriver` in the same directory with `selenium-server-standalone-X.Y.Z.jar` .

```
java -jar selenium-server-standalone-X.Y.Z.jar
```

Default port: `4444`

## ChromeDriver only

```
./chromedriver
```

Default port: `9515`

## PhantomJS

```
./phantomjs --wd
```

Default port: `8910`

## How to use

### WebDriver config file

Create your `webdriver.yml` from `example/webdriver.yml` .

By default, `webdriver.yml` in current working directory is used.

You can put with another file name and/or in another directory by using `--config` ( `-c` ) option.

### Take screenshot

```
php bin/simcap capture:page <captureList>
```

or

```
php simcap.phar capture:page <captureList>
```

### Capture list

Acceptable format is `yml` or `csv` .

No restriction on file name.

#### Yaml example

```yaml
list:
    - name: Yahoo
      url: http://www.yahoo.co.jp/
    - name: Google
      url: http://www.google.co.jp/
```

#### CSV example

```
name,url
Yahoo,http://www.yahoo.co.jp/
Google,http://www.google.co.jp/
```

Acceptable encodings: `ASCII`, `UTF-8`, `SJIS`
