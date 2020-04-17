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
router.get('/', async function(req, res, next) {
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
	
	
	try {
		if (req.session.loggedin) {
			var todays_plan;
			todays_plan = await getTodaysPlan(req.session.user_id);
			console.log(todays_plan);
			
  			res.render('index', { user: req.session.email, date: full_day_date, todays_plan: todays_plan });	
		} else {
			res.render('index', { date: full_day_date });
		}
	} catch (e) {
		next(e)
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


// async function getTodaysPlan(uid, callback) {
// 	var plan;
// 	var q = 'SELECT plan FROM plans WHERE user_id='+uid+' AND created_at = CURDATE()';
// 	connection.query(q, function(error, results) {
// 		if (error) {
// 			callback(err,null);
// 		} else {
// 			callback(null,results[0].plan);
// 		}
// 	});
// }

var stuff;
async var getTodaysPlan = function(uid, callback) {
	var q = 'SELECT plan FROM plans WHERE user_id='+uid+' AND created_at = CURDATE()';
	mysql.connection.query(q, function(err, res, fields) {
		if (err) {
			return callback(err);
		}
		if(res.length) {
			stuff = result[0].plan;
		}
	   callback(null, stuff);
	});
);
	
	

// getInformationFromDB(function (err, result) {
// 	  if (err) console.log("Database error!");
// 	  else console.log(result);
// });

// async function getTodaysPlan(uid) {
// 	var q = 'SELECT plan FROM plans WHERE user_id='+uid+' AND created_at = CURDATE()';
// 		return new Promise((resolve, reject) => {q, (err) => {
// 			if (err) {
// 				return reject(err);
// 			}
// 			return resolve();
// 		}
// 	});
// }

// function getThisWeeksPlans(uid) {

// }

// function getThisMonthsPlans(uid){

// }
module.exports = router;
