var express = require('express');
var db = require('../database');
var Plan = require('../models/plan');

const router = express.Router();

router.get("/", (req, res, next) => {
    // res.status(200).json({
    //     message:"No Plan today",
    //     plan:""
    // });
    // if(session) {
        db.query(Product.getPlanForTodaySQL(req.session.user_id), (err, data)=> {
            if(!err) {
                res.status(200).json({
                    message:"Todays Plan",
                    plan:data
                });
            }
        });
    // } else {
    //     res.status(200).json({
    //         message:"No Plan today",
    //         plan:""
    //     });
    // }    
});

//handles url http://localhost:6001/products/add
router.post("/add", (req, res, next) => {

    //read product information from request
    let product = new Product(req.body.prd_name, req.body.prd_price);

    db.query(product.getAddProductSQL(), (err, data)=> {
        res.status(200).json({
            message:"Product added.",
            productId: data.insertId
        });
    });
});

//handles url http://localhost:6001/products/1001
router.get("/:productId", (req, res, next) => {
    let pid = req.params.productId;

    db.query(Product.getProductByIdSQL(pid), (err, data)=> {
        if(!err) {
            if(data && data.length > 0) {
                
                res.status(200).json({
                    message:"Product found.",
                    product: data
                });
            } else {
                res.status(200).json({
                    message:"Product Not found."
                });
            }
        } 
    });    
});

//handles url http://localhost:6001/products/delete
router.post("/delete", (req, res, next) => {

    var pid = req.body.productId;

    db.query(Product.deleteProductByIdSQL(pid), (err, data)=> {
        if(!err) {
            if(data && data.affectedRows > 0) {
                res.status(200).json({
                    message:`Product deleted with id = ${pid}.`,
                    affectedRows: data.affectedRows
                });
            } else {
                res.status(200).json({
                    message:"Product Not found."
                });
            }
        } 
    });   
});

module.exports = router;