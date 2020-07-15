var modal = "";

function showModal(modalId) {
    document.getElementById(modalId).style.display = "block";
    modal = document.getElementById(modalId);
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
    modal = "";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#output_image').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#customFile").change(function() {
  readURL(this);
});

function deletePrompt(name, location) {
  Swal.fire({
    title: 'Are you sure?',
    text: name +" will be removed",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, remove it!'
  }).then((result) => {
    if (result.value) {
      window.location.href = location;
    }
  })
}


function sortTable(col) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[col];
      y = rows[i + 1].getElementsByTagName("TD")[col];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    document.getElementById("locationMsg").innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  document.getElementById("geolocation").value = 1;
  document.getElementById("longitude").value = position.coords.longitude;
  document.getElementById("latitude").value = position.coords.latitude;
}


var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
  }

  function codeAddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

function onReady(callback) {
  var intervalID = window.setInterval(checkReady, 2000);
  function checkReady() {
      if (document.getElementsByTagName('body')[0] !== undefined) {
          window.clearInterval(intervalID);
          callback.call(this);
      }
  }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('loading', false);
});