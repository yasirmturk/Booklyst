<div class="tab-pane fade show active" role="tabpanel" id="tab-bankContent" aria-labelledby="tab-bank">
    <h2>Bank details</h2>
    <form>
        <div class="form-group">
            <label for="currencyField">Currency</label>
            <select class="form-control" id="currencyField" name="currencyField" aria-describedby="currencyHelp" disabled>
                <option value="gbp">GBP - British Pound</option>
            </select>
            <small id="currencyHelp" class="form-text text-muted">
                To use a different currency you must add a new account.
            </small>
        </div>
        <div class="form-group">
            <label for="countryField">Country of bank account</label>
            <select class="form-control" id="countryField" name="countryField" disabled>
                <option value="GB">United Kingdom</option>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="sortCode">Sort code</label>
                <input class="form-control" id="sortCode">
            </div>
            <div class="form-group col-md-6">
                <label for="accountNumber">Account number</label>
                <input class="form-control" id="accountNumber">
            </div>
        </div>
        <div class="form-group">
            <legend>Account Consent!</legend>
            <small class="form-text text-muted">
                I, the account holder, am the only person required to authorise.
                By submitting a bank account, I authorise XYZ to transfer to this bank account,
                and confirm that I have read and agree to the <a href="#">Services Agreement</a>.
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
