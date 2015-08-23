<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Contact UpstatePHP</h4>
            </div>
            <div class="modal-body">
                <form id="contact-form">
                    {!! Form::token() !!}
                    <input type="hidden" name="subject" value="{!! $contactSubject or 'general-contact' !!}" />
                    <div class="form-group">
                        <label>Name (required)</label>
                        <input type="text" name="name" class="form-control" required pattern="[A-Za-z-0-9]+\s[A-Za-z-'0-9]+"  title="First and Last name are required" />
                    </div>
                    <div class="form-group">
                        <label>Email (required)</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="comments" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfMmQsTAAAAABoalTw18Ya97OHBcBTOdxUVKgVt"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary spinner" id="contact-modal-submit"
                        data-loading-text="Sending <i class='glyphicon glyphicon-refresh icon-spin'>"
                        data-sent-text="Sent <i class='glyphicon glyphicon-ok'>">Send</button>
            </div>
        </div>
    </div>
</div>
