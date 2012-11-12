phpscan2pdf
===========

phpscan2pdf is a simple set of scripts that uses jQuery and AJAX to scan multiple pages from a scanner and create a PDF out of it. I use it to let others use the scanner attached to my computer, without needing to use my computer to scan simple documents.

Warning, the script in it’s current version has basically no security. As there is a “readfile” part to dump the PDF to the browser, a user could easily make it read any file the web server has access too. It also has minimal error checking as generally things just work, and if they don’t, you start again.
