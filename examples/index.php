<?php
///////THIS EXAMPLE USES THE 'world' DATABASE FROM MySQL///////
////GET IT HERE: https://dev.mysql.com/doc/world-setup/en/ ////

	//Include the pagination class
    require_once '../Paginator.class.php';
 
	//Open a connection to a database
    $conn       = new mysqli( '127.0.0.1', 'root', 'password', 'world' );
	
	//Declare Row Limit
////IF $limit IS LOWER THAN 1 IT DEFAULTS TO 25////
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
	
	//Declare Current Page
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
	
	//Declare Pagination Links
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query      = "SELECT City.Name, City.CountryCode, Country.Code, Country.Name AS Country, Country.Continent, Country.Region FROM City, Country WHERE City.CountryCode = Country.Code";
	
	//Open the pagination class
    $Paginator  = new Paginator( $conn, $query );
 
	//Create a variable for the results
    $results    = $Paginator->getData( $limit, $page );
?>
<!DOCTYPE html>
    <head>
        <title>PHP Pagination</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="col-md-10 col-md-offset-1">
				<div class="col-lg-8">
					<h1>PHP Pagination</h1>
				</div>
				<?php //Input box for user-set limits ?>
			  <form method="get" action="">
				<div class="col-lg-2">
					<div class="input-group">
						<input type="text" class="form-control" name="limit" value="<?=$limit?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Update</button>
						</span>
					</div>
				</div>
				<input type="hidden" name="page" value="<?=$page?>">
			  </form>
				<?php //End Input box for user-set limits ?>
                <table class="table table-striped table-condensed table-bordered table-rounded">
                        <thead>
                                <tr>
                                <th>City</th>
                                <th width="20%">Country</th>
                                <th width="20%">Continent</th>
                                <th width="25%">Region</th>
                        </tr>
                        </thead>
                        <tbody>
							<?php
								//Display the data fetched from the database
								for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
								<tr>
										<td><?php echo $results->data[$i]['Name']; ?></td>
										<td><?php echo $results->data[$i]['Country']; ?></td>
										<td><?php echo $results->data[$i]['Continent']; ?></td>
										<td><?php echo $results->data[$i]['Region']; ?></td>
								</tr>
							<?php endfor; ?>
						</tbody>
                </table>
				<?php
					//Create the pagination links
					//First parameter is an INT for amount of links to be shown at a time
					//Second parameter is for the class of the pagination bar (This uses Bootstrap)
					echo $Paginator->createLinks( $links, 'pagination pagination-sm' );
				?>
            </div>
        </div>
        </body>
</html>