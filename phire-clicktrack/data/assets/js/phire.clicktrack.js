/**
 * ClickTrack Module Scripts for Phire CMS 2
 */

jax(document).ready(function(){
    if (jax('#clicks-form')[0] != undefined) {
        jax('#checkall').click(function(){
            if (this.checked) {
                jax('#clicks-form').checkAll(this.value);
            } else {
                jax('#clicks-form').uncheckAll(this.value);
            }
        });
        jax('#clicks-form').submit(function(){
            return jax('#clicks-form').checkValidate('checkbox', true);
        });
    }
});