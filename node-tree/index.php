
<!DOCTYPE html>
<html>
 <head>
  <title>How to Add New Node in Dynamic Treeview using PHP Mysql Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>    
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
  <style>
  </style>
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center">How to Add New Node in Dynamic Treeview using PHP Mysql Ajax</h2>
   <br /><br />
   <div class="row">
    <div class="col-md-6">

     <h3 align="center"><u>Add New Category</u></h3>
     <br />


     <form method="post" id="treeview_form">

        <div class="form-group">
        <label>Select Parent Category</label>
        <select name="parent_category" id="parent_category" class="form-control">
        </select>
        </div>

        <div class="form-group">
        <label>Enter Category Name</label>
        <input type="text" name="category_name" id="category_name" class="form-control">
        </div>
        
        <div class="form-group">
        <input type="submit" name="action" id="action" value="Add" class="btn btn-info" />
        </div>

     </form>


    </div>



    <div class="col-md-6">

     <h3 align="center"><u>Category Tree</u></h3>
     <br />
     <div id="treeview"></div>

    </div>

   </div>
  </div>
 </body>
</html>


<script>

//filling parent category select box using ajax function
$(document).ready(function(){

    /*
    we call firstfill_parent_category ftc.
    this ftc will be called when page load and will fill fill_parent_category select box
    */
    fill_parent_category();
    // also call thi function after submitting the form s that it diplays automatically the new added item


/*
     this ftc will be called when page load and and make dynamic treeview display
    */
    fill_treeview();


    //fetch data from category table and display on webpage
    function fill_treeview(){
        $.ajax({
            url:"fetch.php",
            dataType:"json",
            success:function(data){

                //we initializ the bootstrap treeview function
                $('#treeview').treeview({
                    //data option will display DATA from table and make treeview
                    data:data
                });

            }
        })
    }


    function fill_parent_category()
    {
         /*ajax request where first option = url _ we sent request to a page
            success callback fct to call a request successfuly completed and receive data from server
            we fill parent_category select box with the data we get from success 
        */ 
        $.ajax({
            url:'fill_parent_category.php',
            success:function(data){
                $('#parent_category').html(data);
            }
        });
    }


    //to submit form
    $('#treeview_form').on('submit', function(event){

        /*
        to stop to submit form_data to server : event.preventDefault();
        data:$(this).serialize() : we define ethe data we want to send to the server, serialize() method will convert form data into url encoded sting
        success callback fct will be called if request compteted succesffuly and it will receive DATA from server. 
        we can access to those data via data argument in function(data)
        */
        event.preventDefault();
        $.ajax({
            url:"add.php",
            method:"POST",
            data:$(this).serialize(),
            success:function(data){
                fill_treeview();
                fill_parent_category(); //will fetch category name and fill them in category selectbox
                //we then clean form field after submiting form.
                //the reset method will reset all form fields.
                $('#treeview_form')[0].reset();
                //we popup alert message on webpage
                alert(data);
            }
        })

    });
     
  
});
</script>