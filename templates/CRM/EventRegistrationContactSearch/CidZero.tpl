<div class="eventregistrationcontactsearch-cidzero-div">
  {include file="CRM/common/cidzero.tpl"}
</div>
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $('form.CRM_Event_Form_Registration_AdditionalParticipant div.crm-public-form-item:first')
      .before($('div.eventregistrationcontactsearch-cidzero-div'));
  });
</script>
{/literal}
