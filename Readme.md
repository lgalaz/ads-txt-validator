# Ads.txt Validator 

This is test project for a validator of Ads.txt files according to the following rules:

The format logically consists of:
- A non-empty set of records, separated by line breaks. The records consist of a set of
lines of the form:
<FIELD #1>, <FIELD #2>, <FIELD #3>, <FIELD #4>
or
<VARIABLE>=<VALUE>

- Lines starting with # symbol are considered comments and are ignored
- records contain comma-separated fields, 3 fields are required, 1 field is optional


The format is described in detail here, in Section 3.2:

https://iabtechlab.com/wp-content/uploads/2017/09/IABOpenRTB_Ads.txt_Public_Spec_V1-0-1.pdf

## Installation

### Prerequisites

- To run this project, you must have PHP 7 installed.
- You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 


### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone git@github.com:lgalaz/ads-txt-validator.git
cd ads-txt-validator && composer install && npm install
```

### Step 2

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://ads-txt-validator.test`. 
