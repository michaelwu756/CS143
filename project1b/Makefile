P1B.zip: 404751542/*
	zip -r $@ $^

reload_data: 404751542/*
	mysql CS143 < auxiliaryScripts/droptable.sql
	mysql CS143 < 404751542/create.sql
	mysql CS143 < 404751542/load.sql
