<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            input:not([type='checkbox']) {
                width:50%;
            }
        </style>
    </head>
    <body>
        <h1>Add a New Coffee To The List</h1>
        <form action="create" method="POST">
            <input type="text" name="drink" placeholder="Drink"/><br/>
            <input type="text" name="guest" placeholder="How May I Butcher Your Anme?"/><br/>
            Whipped Cream <input type="checkbox" name="whipped_cream"/><br/>
            Extra Shot of Espresso <input type="checkbox" name="extra_espresso"/><br/>
            <input type="submit" value="Submit"/>
        </form>
    </body>
</html>