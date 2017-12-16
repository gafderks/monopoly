function init() {
  bindNavigationButtons();
  logIn();
  updateAll(null);
  console.log("initialized");
  setInterval(function(){
    updateAll(null);
  }, 2000);
  //setInterval(function(){
  //  locate();
  //}, 2000);
}

function logIn(callback) {
  if (localStorage.getItem("user") == null) {
    localStorage.setItem("visited", JSON.stringify([]));
    localStorage.setItem("transactions", JSON.stringify([]));
    var name = prompt("Vul je teamnaam in");
    $.ajax({
      type: "POST",
      url: "api.php?action=create&resource=team",
      data: {'name': name},
      success: callback
    });
    localStorage.setItem("user", name);
  }
}

function bindNavigationButtons() {
  $("[data-page]").click(function() {
    $(".page").addClass("d-none");
    $("#"+$(this).data("page")).removeClass("d-none");
    $("[data-page]").parent().removeClass("active");
    $(this).parent().addClass("active");
    $(this).parent().parent().parent().removeClass("show");
  });
}

function fetchAll(callback) {
  updateLocations(function() {
    updateBalance(function() {
      updateScoreTable(null);
    })
  });
}

function updateAll(callback) {
  fetchAll(function() {
    locate();
    if (typeof callback ==='function') {
      callback();
    }
  });
}

function locate() {
  navigator.geolocation.getCurrentPosition(checkIfNearLocation);
}

function updateLocations(callback) {
  $.get( "api.php?action=list&resource=locations&rand="+Math.random(), function(
    data ) {
    locations = data;
    updateDestinations();
    if (typeof callback ==='function') {
      callback();
    }
  });
}

function updateDestinations() {
  $("#destinations").text("");
  for (var i = 0; i < locations.length; i++) {
    $("#destinations").append($("<li>" + locations[i].name + "</li>").css
                                                                      ("color", locations[i].color));
  }
}

function updateBalance(callback) {
  $.get( "api.php?action=list&resource=transactions&rand="+Math.random()+"&name" +
         "="+localStorage
         .getItem("user"), function(
    data ) {
    var b = 0;
    for (var i = 0; i < data.length; i++) {
      b = b + data[i].amount;
      var transactions = JSON.parse(localStorage.getItem("transactions"));
      if (transactions.length === 0 || (transactions.indexOf(i) === -1)) {
        transactions[transactions.length] = i;
        localStorage.setItem("transactions", JSON.stringify(transactions));
        if (data[i].amount > 0) {
          window.alert("WINST: Je hebt €" + data[i].amount + " verdiend.");
        } else {
          window.alert("VERLIES: Je hebt €" + -1*data[i].amount + " betaald.");
        }

      }
    }
    $("#balance").text(b);
    balance = b;
    if (typeof callback ==='function') {
      callback();
    }
  });

}

function updateScoreTable(callback) {
  $.get( "api.php?action=list&resource=scores&rand="+Math.random(), function(
    data ) {
    $("#score-table").html("");
    for (var i = 0; i < data.length; i++) {
      $("#score-table").append(
        "<tr><td>"+data[i].name+"</td><td>"+data[i].ownerships+"</td><td>&euro; "+data[i].balance+"</td></tr>"
      );
    }
    if (typeof callback ==='function') {
      callback();
    }
  });

}

function checkIfNearLocation(location) {
  for (var i = 0; i < locations.length; i++) {
    var distance = getDistanceFromLatLonInKm(
      location.coords.latitude,
      location.coords.longitude,
      locations[i].location.lat,
      locations[i].location.lon
    );
    if (distance <= 0.1) {
      var visited = JSON.parse(localStorage.getItem("visited"));
      if (visited.length === 0 || (visited[visited.length - 1] !== i)) {
        visited[visited.length] = i;
        localStorage.setItem("visited", JSON.stringify(visited));
        if (visited.length % 2 === 0) {
          getBonus(null);
        }
        openCard(locations[i], true)
      }

      openCard(locations[i], false);
      return;
    }
    $(".monopoly-card").addClass("d-none");
    $(".compass").removeClass("d-none");
  }
}

function buyProperty(locationId, callback) {
  $.ajax({
    type: "POST",
    url: "api.php?action=create&resource=ownership",
    data: {'location': locationId, 'name': localStorage.getItem('user')},

    success: function() {
      updateAll(callback);
    }
  });
}

function payRent(teamName, amount, callback) {
  $.ajax({
    type: "POST",
    url: "api.php?action=create&resource=transaction",
    data: {
      'type': 'rent',
      'from': localStorage.getItem('user'),
      'to': teamName,
      'amount': amount
    },
    success: function() {
      updateAll(callback);
    }
  });
}

function getBonus(callback) {
  $.ajax({
    type: "POST",
    url: "api.php?action=create&resource=transaction",
    data: {'type': 'bonus', 'name': localStorage.getItem('user')},
    success: function() {
      updateAll(callback);
    }
  });
}

function openCard(card, newlyVisited) {
  $(".monopoly-card").removeClass("d-none");
  $(".compass").addClass("d-none");

  $("#m-name").text(card.name);
  $("#m-name").css("background", card.color);
  $("#m-name").css("color", card.text);
  $("#m-image").attr("src", "img/"+card.image);
  $("#m-price").text(card.price);
  $("#m-rent").text(card.rent);

  $(".ownership").addClass("d-none");
  $(".ownership").removeClass("d-block");
  if (card.owner === null) {
    if (balance < card.price) {
      $("#buy-button-disabled").addClass("d-block");
    } else {
      $("#buy-button").addClass("d-block");
      $("#buy-button").prop("disabled", false);
      $("#buy-button").unbind();
      $("#buy-button").click(function() {
        $("#buy-button").prop("disabled", true);
        buyProperty(card.id, null);
      });
    }
  } else {
    $("#owner").text(card.owner);
    $("#buy-unavailable").addClass("d-block");
    if (localStorage.getItem("user") !== card.owner && newlyVisited) {
      payRent(card.owner, card.rent, null);
    }
  }
}

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1);
  var a =
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon/2) * Math.sin(dLon/2)
  ;
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}