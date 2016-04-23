
  function getBooksByTranslation(personid) {
    var dynamicData = {};
    dynamicData["id"] = personID;
    return $.ajax({
      url: "getName.php",
      type: "get",
      data: dynamicData
    });
  }


