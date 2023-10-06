<!-- Tagify -->
<div class="col-12" id="tagify-col">
    <div class="card mb-4 filters">
        <div class="d-inline-flex">
            <i class="fa-solid fa-angle-down"></i>
            <i class="fa-solid fa-angle-up d-none"></i>
            <h5 class="card-header">{{ __('Filters') }}</h5>
        </div>
        <div class="card-body d-none">
            <div class="row">
                <!-- Basic -->
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input id="TagifyBasic" class="form-control" name="TagifyBasic" value="Tag1, Tag2, Tag3" />
                        <label for="TagifyBasic">Basic</label>
                    </div>
                </div>
                <!-- Readonly Mode -->
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input id="TagifyReadonly" class="form-control" readonly value="Tag1, Tag2, Tag3" />
                        <label for="TagifyReadonly">Readonly</label>
                    </div>
                </div>
                <!-- Custom Suggestions: Inline -->
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input id="TagifyCustomInlineSuggestion" name="TagifyCustomInlineSuggestion" class="form-control h-auto" placeholder="select technologies" value="css, html, javascript">
                        <label for="TagifyCustomInlineSuggestion">Custom Inline Suggestions</label>
                    </div>
                </div>
                <!-- Custom Suggestions: List -->
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input id="TagifyCustomListSuggestion" name="TagifyCustomListSuggestion" class="form-control h-auto" placeholder="select technologies" value="css, html, php">
                        <label for="TagifyCustomListSuggestion">Custom List Suggestions</label>
                    </div>
                </div>
                <!-- Users List -->
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input id="TagifyUserList" name="TagifyUserList" class="form-control h-auto" value="abatisse2@nih.gov, Justinian Hattersley" />
                        <label for="TagifyUserList">Users List</label>
                    </div>
                </div>
                <!-- Email -->
                <div class="col-md-6 mb-4">
                    <label for="TagifyEmailList" class="form-label d-block">Email List</label>
                    <input id="TagifyEmailList" class="tagify-email-list" value="some56.name@website.com">
                    <button type="button" class="btn btn-sm rounded-pill btn-icon btn-outline-primary mb-1"> <span class="tf-icons mdi mdi-plus"></span> </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Tagify -->

<script>
    // Make Filters retractable
    $('.filters .fa-solid').click((e)=>{
        if ($(e.currentTarget).hasClass('fa-angle-up')) {
            $('.filters .card-body').addClass('d-none')
            $('.filters .fa-angle-up').addClass('d-none')
            $('.filters .fa-angle-down').removeClass('d-none')
        } else if ($(e.currentTarget).hasClass('fa-angle-down')) {
            $('.filters .card-body').removeClass('d-none')
            $('.filters .fa-angle-up').removeClass('d-none')
            $('.filters .fa-angle-down').addClass('d-none')
        }
    })
</script>