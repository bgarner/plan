class Plan {
    
    constructor(uid,plan) {
    	var date = new Date();
    	var today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    	this.user_id = 1;
      this.share_id = crypto.randomBytes(64).toString('hex');
      this.plan = plan;
      this.created_at=today;
    }

    getAddPlanSQL() {
      let sql = 'INSERT INTO plans(user_id, share_id, plan, created_at) VALUES('+this.user_id+',`'+this.share_id+'`,`'+this.plan+'`, `'+this.created_at+'`)';
      return sql;           
    }

    static getPlanByIdShareIdSQL(share_id) {
      let sql = 'SELECT * FROM plans WHERE share_id = '+share_id;
      return sql;           
    }

    static getPlanForTodaySQL(user_id) {
    	let sql = 'SELECT plan FROM plans WHERE user_id = '+user_id+' AND created_at = CURDATE()';
    	return sql;
    }

}

module.exports = Plan;