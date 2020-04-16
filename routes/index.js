var app = require('express');
var mysql = require('mysql');
var session = require('express-session');
var bodyParser = require('body-parser');
var path = require('path');
var router = app.Router();

var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  database: 'plan'
});

/* GET home page. */
router.get('/', function(req, res, next) {
	var date = new Date();

	var weekday = new Array(7);
	weekday[0] = "Sun";
	weekday[1] = "Mon";
	weekday[2] = "Tue";
	weekday[3] = "Wed";
	weekday[4] = "Thu";
	weekday[5] = "Fri";
	weekday[6] = "Sat";

	var today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
	var day = weekday[date.getDay()];
	var full_day_date = day+"_"+today;
	var todays_plan = "";
	if (req.session.loggedin) {
  	// get the todays plan if there is one
  	var q = 'SELECT plan FROM plans WHERE user_id='+req.session.user_id+' AND created_at = CURDATE()';
		connection.query(q, function(error, results, fields) {
			if (results.length > 0) {
				todays_plan = results[0].plan;
				console.log(todays_plan);
				res.render('index', { user: req.session.email, date: full_day_date, todays_plan: todays_plan });
			} else {
				console.log("no plan today");
				res.render('index', { user: req.session.email, date: full_day_date });
			}
		});

		
		//get the last weeks worth
		//get the last month
		
	} else {
		console.log('not logged in');
		res.render('index', { date: full_day_date });
	}
});

router.post('/auth', function(req, res) {
	var email = req.body.login_email;
	var password = req.body.login_password;
	if (email && password) {
		connection.query('SELECT * FROM users WHERE email = ? AND password = ?', [email, password], function(error, results, fields) {
			if (results.length > 0) {
				req.session.loggedin = true;
				req.session.email = email;
				req.session.user_id = results[0].id;
				
				res.redirect('/');
			} else {
				res.send('Incorrect Username and/or Password!');
			}			
			res.end();
		});
	} else {
		res.send('Please enter Username and Password!');
		res.end();
	}
});

module.exports = router;
