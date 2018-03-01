# Data-Table

This function creates an interactive table with all kind of data (data query result, matrix, csv or xml). The complicated Datatables.org libraries has been simplified in this function.
This function accepts two parameters:
1- a data set: this data set is a PHP result set regardless of the database type (postgreSQL, mySQL, SQL Server or ...)
2- an array which indicates columns that need a total aggregation in the footer table
functionalities:
1- This is a hover table
2- By clicking on each row we can load row values using JQuery capabilities
3- It has a pagination 
4- Ability to choose the number of rows in each page
5- Incremental search on the entire of table contents
6- Export to csv file 
7- Ascending and descending sort by click on columns. This feature can be extended by selecting combination columns
8- This table can have footer with aggregation of total amount,count and average
