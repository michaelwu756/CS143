P1B.zip: 404751542/readme.txt 404751542/team.txt 404751542/create.sql 404751542/load.sql 404751542/queries.sql 404751542/query.php 404751542/violate.sql
	zip -r $@ $^

reload_data: 404751542/*
	mysql CS143 < 404751542/droptable.sql
	mysql CS143 < 404751542/create.sql
	cp 404751542/load.sql ~/data/load.sql
	cd ~/data && mysql CS143 < load.sql
