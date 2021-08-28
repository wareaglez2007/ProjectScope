$(function () {
    var URI = location.pathname;
    var pathArray = window.location.pathname.split('/');
   // if (URI === '/admin/groups' || URI === '/admin/roles' || URI === '/admin/permissions' || URI === '/admin/modules') {
        uri_to_check = new Array('groups', 'roles', 'permissions', 'modules');
        if(pathArray[1] == 'admin' &&  ($.inArray(pathArray[2], uri_to_check) !== -1)){
            $('#collapseFive').collapse('show');
        }
        
   // }


   // 

    //console.log(pathArray);


   // myArray = new Array("php", "tutor");
    //if( $.inArray("php", myArray) !== -1 ) {
    
    //    alert("found");
   // }
});