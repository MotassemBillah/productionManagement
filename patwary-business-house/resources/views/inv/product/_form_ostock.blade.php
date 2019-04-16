<div class="modal-dialog modal-sm" role="document" style="">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span aria-hidden="true">x</span></button>
            <h4 class="modal-title">Opening Stock Form</h4>
        </div>
        <form action="" id="frmOpeningStock" name="frmOpeningStock" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="productID" name="productID" value="<?= $resp['productID']; ?>">
            <div class="modal-body" style="">
                <div class="mb_10 clearfix">
                    <label for="qty">Quantity</label>
                    <input type="number" class="form-control" id="qty" name="qty" value="<?= $resp['qty']; ?>" min="0" required>
                </div>
                <div class="mb_10 clearfix">
                    <label for="avg_price">AVG Price</label>
                    <input type="number" class="form-control" id="avg_price" name="avg_price" value="<?= $resp['avg_price']; ?>" min="0" step="any" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-block" id="saveChange" name="saveChange" value="<?= ($resp['new'] == true) ? "Save" : "Update"; ?>">
            </div>
        </form>
    </div>
</div>