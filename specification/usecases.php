<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="../css/bulkflow.css" rel="stylesheet" type="text/css" />
		<title>Capstone Use Cases</title>
	</head>
	<body>
		<h1>The Individual</h1>
		<p>
			It's just another boring day for Mr. Bayer at DM Paper, and instead of boosting his
			sales, Ted decides he is going to browse the internet (strangely, not a foreign concept for him).
			Ted is completing a "Which Quirky Sitcom Character Are You?" quiz when he notices an ad on the
			last of the 12 pages he's had to click through to get to his answer. It is an ad featuring
			several of our political and humorous figurines, along with some cartooney words promising
			that they're "perfect for gifts or your desk!". Intrigued, he opens the site in a new tab.
		</p>
		<p>
			Finished clicking through the 'funny' galleries linked to him on Facebook (#7 will blow your
			mind!), the last tab that is open is our home page; Ted vaguely recalls opening it, and scrolls
			through our landing page. After scrolling up again he ignores the vague feeling of being impressed
			with the smooth and responsive page, and clicks "Shop", interested in our products. Chuckling as he
			browses, Ted finds a few figurines he likes and clicks to add them to his cart. After reaching the end
			of our products, he clicks cart to view his total, and proceeds to checkout. He elects to create an account,
			having noticed several products he may choose to buy in the future. Inputting a username, password, and email
			into the account creator, he then enters his payment information into the form connected to Stripe, and then
			selects his shipping choice and inputs his address. After paying and shipping, he checks his email for his
			order receipt, and verifies his profile via the email we sent when he signed up, leaving him to land on his
			account page.
		</p>
		<img src="../img/individualflow.png" />
		<hr />
		<h1>The Admin</h1>
		<p>
			Using his iPad on a lunch break to add another figurine to his online
			marketplace, Gregory attempts to add the governor local to his state,
			being a possible Presidential candidate in the near future. He signs in to
			the administrator account he has permissions on, and navigates to the
			product page. He clicks a gigantic "Add..." button on his
			administrator bar. Greg uses a popup to add a picture of the prototype of
			his governor that he has locally stored on his iPad. The upload takes a second,
			then he is taken to Add Product page, where he can select the category,
			whether the item is New (and therefore should be on the front page), and place
			tags for search-ability in (state name, governor tag, political tag etc.).
		</p>
		<p>
			He doesn't have enough time to finish just yet, so he puts away his iPad after
			his lunch break is over, and is able to resume the process later at home.
		</p>
		<p>
			Later, on his Macbook, after adding all required fields, he clicks Submit. Now if
			a customer checks the site, the update will display as a new product, and display
			prominently on the front page in addition to it's respective place on product pages.
		</p>

		<img src="../img/adminflow.png" />
		<hr />
		<h1>Bulk Buyer</h1>
		<p>
			It's a rare leisurely Sunday morning and Mr. Zapata is casually perusing Facebook, coffee in hand,
			when an obscene amount of likes on a post catches his attention. He notices the source of the uproar
			is a set of humorous plastic likenesses depicting popular political/entertainment figures. Instantly,
			and motivated by the beautiful large 5K iMac screen he's sitting in front of, he feels compelled to
			incorporate this trending phenomenon into his public outreach program for the upcoming political rally
			being held at UC Berkeley in two weeks. He navigates to the site via Facebook and is greeted with a simple
			call to action asking him to log in or head to the shop. Choosing to check out the options before signing up
			for an account, he clicks the Shop button. This brings him to the product page, where he instantly sees
			a super-villain version of Dick Cheney that will be perfect for the 20-somethings he's hoping to hook at the event.
			Choosing a hundred figurines from the Qty option box, he's pleasantly surprised when a bulk buyer discount is
			automatically supplied to his grand total, saving him 20% of the total order. Since the site developers have customized
			a clean, open-source version of a shopping cart module that integrates nicely with the Stripes API, he has
			a very smooth and secure checkout experience, finalized with a friendly order confirmation sent to his business email account.
		</p>
		<img id="bulkflow" src="../img/bulkflow.png" />
	</body>
</html>