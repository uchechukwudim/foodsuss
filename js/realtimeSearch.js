
  src="http://localhost/js/jquery-2.0.0.js";
  src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js">
  function getquery()
  {
      $("#search").keyup(function(){
          var query = $(this).val();
          data = {query: query};
          if(query.length === 0 || query === " ")
              return false;
           alert(query);
      });
      
       $("#search").focus();
  };
 

