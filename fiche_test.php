Fatal error: Uncaught PDOException: SQLSTATE[22007]: Invalid datetime format: 1366 Incorrect integer value: 'Marillion' for column `record`.`disc`.`artist_id` at row 1 in /home/mahe/Bureau/velvet_record/edit_disc.php on line 46
( ! ) PDOException: SQLSTATE[22007]: Invalid datetime format: 1366 Incorrect integer value: 'Marillion' for column `record`.`disc`.`artist_id` at row 1 in /home/mahe/Bureau/velvet_record/edit_disc.php on line 46
Call Stack
#	Time	Memory	Function	Location
1	0.0000	360368	{main}( )	.../edit_disc.php:0
2	0.0005	422920	execute( $params = ['artist' => 'Marillion', 'label' => 'EMI', 'year' => '1984', 'genre' => 'Prog', 'price' => '14.99', 'id' => '1'] )	.../edit_disc.php:46