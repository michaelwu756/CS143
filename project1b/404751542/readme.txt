This creates the CS143 database tables for project 1, which can be
achieved by running

mysql CS143 < create.sql

To load the data, run as follows

mysql CS143 < load.sql

which will load the data from the .del files into the database. Note
that this command will only work if the ~/data/ directory containing
the .del files exists . The queries.sql contains example queries to
run on the database after the data has been loaded, and the
violate.sql contains examples of inserts that violate referential
integrity or check constraints.

The webpage query.php can be accessed through html to run queries on
the database.

Team members on this project are Jennie Zheng and Michael Wu. The
division of labor was as follows:

Jennie: Wrote query.php and created test cases for violate.sql and
	query.sql, as well as designing tables.

Michael: Worked on verifying restraints on create.sql, verifying table
	structure, managed version control, wrote readme.txt.

We met up and worked together to finish this in person, which took
about two hours.
