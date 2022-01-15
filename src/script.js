$(document).ready(function(){
	var user={};

	function register(e){
		user.idnumber = document.getElementById('idnumber').value;
		user.firstname = document.getElementById('firstname').value;
		user.lastname = document.getElementById('lastname').value;
		user.gender = document.getElementById('gender').value;
		user.bday = document.getElementById('bday').value;
		user.program = document.getElementById('program').value;
		user.yearlevel = document.getElementById('yearlevel').value;
		console.log(user);

		$.ajax({
			type:"POST",
			data:{action:"register", userdata:user},
			url:"src/php/user.php",
			success:function(response){
				idresponse = jQuery.parseJSON(response);
				var table = $("#usertable tbody");
				if(idresponse==0){
					alert("Error saving the user!");
				}else{
					user.id = idresponse;
					appendUser(user, table);
				}
				$("#userForm").find("input, select").val("");
			},
		});


		e.preventDefault();
	}


	function getUsers(){
		$.ajax({
			type:"GET",
			data:{action:"getusers"},
			url:"src/php/user.php",
			success:function(response){
				users = jQuery.parseJSON(response);
				var table = $("#usertable tbody");
				for(var i =0; i < users.length;i++){
					appendUser(users[i], table);
				}
			},
		});
	}


	function deleteID(e){
		delID = document.getElementById('id_delete').value;

		$.ajax({
			type:"GET",
			data:{action:"get_ID", userID:delID},
			url:"src/php/user.php"
		}); 
 
		//e.preventDefault(); 
	}

	function updateID(e){

		user.id = document.getElementById('id_update').value;
		user.idnumber = document.getElementById('id#_update').value;
		user.firstname = document.getElementById('first_update').value;
		user.lastname = document.getElementById('last_update').value;
		user.gender = document.getElementById('gender_update').value;
		user.bday = document.getElementById('bday_update').value;
		user.program = document.getElementById('prog_update').value;
		user.yearlevel = document.getElementById('year_update').value;
		console.log(user);

		$.ajax({
			type:"POST",
			data:{action:"update", userdata:user},
			url:"src/php/user.php"
		});

		e.preventDefault(); 
	}


	function appendUser(user, table){
		row = "<tr>"+
			"<th scope=\"row\">"+ user.id +"</th>"+
		      "<td>"+ user.idnumber +"</td>"+
		      "<td>"+ user.firstname +"</td>"+
		      "<td>"+ user.lastname +"</td>"+
		      "<td>"+ user.gender +"</td>"+
		      "<td>"+ user.bday +"</td>"+
		      "<td>"+ user.program +"</td>"+
		      "<td>"+ user.yearlevel +"</td>"+
			"</tr>";	
		table.append(row);	
	}

	/*function deleteUser(user, table){
		row = "<tr>"+
			"<th scope=\"row\">"+ user.id +"</th>"+
		      "<td>"+ user.idnumber +"</td>"+
		      "<td>"+ user.firstname +"</td>"+
		      "<td>"+ user.lastname +"</td>"+
		      "<td>"+ user.gender +"</td>"+
		      "<td>"+ user.bday +"</td>"+
		      "<td>"+ user.program +"</td>"+
		      "<td>"+ user.yearlevel +"</td>"+
			"</tr>";	
		table.remove(row);	
	}*/

	$("#updateForm").submit(updateID);
	$("#userForm").submit(register);
	$("#deleteForm").submit(deleteID);

	getUsers();
});
