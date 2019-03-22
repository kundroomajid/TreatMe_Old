function onload(event) {

	var starRating = raterJs( {
		starSize:16,
		isBusyText: "Rating in progress. Please wait...",
		element:document.querySelector("#rater"),
		rateCallback:function rateCallback(rating, done) {
			var parentObject = this;
			window.location:'rating.php?'
			$.ajax({
				url : "rating.php",
				data : 'id=' + 1 + '&rating='
				+ rating,
				type : "POST",
				success : function(data) {
					o = JSON.parse(data);
					parentObject.setRating(o.rating);
					alert("your ratings have been saved");
				}
			});

			//starRating.disable();
			done();
		}
	});

}

window.addEventListener("load", onload, false);
