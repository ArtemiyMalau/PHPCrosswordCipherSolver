// var core = require("./../../core.js");
// var contestCore = require("./../contests_core.js");

window.onload = function () {
	let templates = {}
	templates.char = 
		`
		<div class="col-2 char" js-char>
			<input class="form-control" type="text" name="cipher[<%= numberIndex %>][chars][]" value="А" maxlength="1" required=>
			<a href="##" class="remove fas fa-times" js-delete-char=""></a>
		</div>
		`
	templates.number = 
		`
		<div class="row number-row" js-number-row data-numberindex="<%= numberIndex %>">
			<div class="col-2">
				<input class="form-control" type="number" name="cipher[<%= numberIndex %>][number]"  value="1" min="0" max="9" required>
			</div>
			<div class="col">
				<div class="row" js-char-row>
					${templates.char}
					<a href="##" class="col-2" js-add-char>
						<i class="fas fa-plus-circle fa-2x"></i>
					</a>
				</div>
			</div>
			<div class="col-1">
			<a href="##" class="btn btn-sm" js-delete-number>
				<i class="far fa-trash-alt fa-lg" data-toggle="tooltip" data-placement="top" title="Удалить число"></i>
			</a>
			</div>
		</div>
		`
	templates.possibleWords = 
		`
		<% words.forEach(function(word) { %>
			<p><%= word %></p>
		<% }); %>
		`

	// Countdown rows-related events
	let cipherNumber = $("#cipherNumbers");
	let numberIndex = cipherNumber.find("[js-number-row]").length;

	$("[js-add-number]").on("click", function(e) {
		console.log("add-number");

		cipherNumber.append(ejs.render(templates.number, {numberIndex: numberIndex}));
		numberIndex += 1;
	})

	$("body").on("click", "[js-delete-number]", function(e) {
		console.log("delete-number");

		let $this = $(this);

		if (cipherNumber.find("[js-number-row]").length > 1) {
			$this.closest("[js-number-row]").remove();
		} else {
			alert("Необходим минимум один компонент шифра");
		}		
	})	

	$("body").on("click", "[js-add-char]", function(e) {
		console.log("add-char");

		let $this = $(this);
		console.log($this.closest("[js-char-row]"));
		// Placing char before add char button
		$this.closest("[js-char-row]").find($this).before(ejs.render(templates.char, {
			numberIndex: $this.closest("[js-number-row]").data("numberindex")
		}));
	})

	$("body").on("click", "[js-delete-char]", function(e) {
		console.log("delete-char");
		let $this = $(this);

		if ($this.closest("[js-char-row]").find("[js-char]").length > 1) {
			$this.closest("[js-char]").remove();
		} else {
			alert("Необходима минимум одна буква для сопоставления с числом");
		}
	})

	$("form").submit(function(e) { 
		console.log("sending form");
		e.preventDefault();

        console.log($(this));
        axios.post($(this).attr("action"), new FormData(this))
        	.then(function (response) {
        		let words = response.data;

        		console.log($("#possibleWords"));
        		$("#possibleWords").html(ejs.render(templates.possibleWords, words));
        		$("#modalSuccess").modal("show");
        	})
        	.catch(error => {
        		console.log("error", error);
        		
        		$("#modalFailure").modal("show");
        	});
    });

	$("[js-add-number]").click();
}