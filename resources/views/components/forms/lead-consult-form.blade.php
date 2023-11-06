<div x-show= "selected_action == 'Consulted'" class=" lg:w-fit bg-base-200 rounded-lg p-3 mt-3">

    {{-- <template x-if="lead.status == 'Closed'">
        <p class=" font-medium text-error py-4 text-base">This lead is closed</p>
    </template> --}}
    {{-- <template x-if="lead.status == 'Consulted'">
        <p class=" font-medium text-error py-4 text-base">This lead is Consulted</p>
    </template> --}}

    <form
                                x-data="{
                                    doSubmit() {
                                        let form = document.getElementById('mark-consulted-form');
                                        let formdata = new FormData(form);
                                        formdata.append('followup_id',fp.id);
                                        formdata.append('lead_id',fp.lead.id);
                                        $dispatch('formsubmit',{url:'{{route('consulted.mark')}}', route: 'consulted.mark',fragment: 'page-content', formData: formdata, target: 'mark-consulted-form'});
                                    }
                                }"

                                @submit.prevent.stop="doSubmit()"

                                @formresponse.window="
                                if ($event.detail.target == $el.id) {
                                    if ($event.detail.content.success) {
                                        $dispatch('showtoast', {message: $event.detail.content.message, mode: 'success'});
                                        $el.reset();

                                        if($event.detail.content.lead != null || $event.detail.content.lead != undefined){
                                            lead.status = $event.detail.content.lead.status;
                                            {{-- console.log(lead.status); --}}
                                        }

                                        if($event.detail.content.followup != null || $event.detail.content.followup != undefined){
                                            fp.consulted = $event.detail.content.followup.consulted;
                                            console.log(fp.consulted);
                                        }
                                        if ($event.detail.content.next_followup) {
                                            fp.next_followup_date = $event.detail.content.next_followup.scheduled_date;
                                        }
                                        if($event.detail.content.appointment != null && $event.detail.content != undefined){
                                            lead.appointment.remarks = $event.detail.content.appointment.remarks;
                                        }
                                        $dispatch('formerrors', {errors: []});
                                    }

                                    else if (typeof $event.detail.content.errors != undefined) {
                                        $dispatch('showtoast', {message: $event.detail.content.message, mode: 'error'});

                                    } else{
                                        $dispatch('formerrors', {errors: $event.detail.content.errors});
                                    }
                                }"
                            x-show="!fp.consulted && lead.status=='Appointment Fixed'" x-cloak x-transition id="mark-consulted-form" action="" class=" rounded-xl lg:w-fit">

                                <h1 class=" text-secondary font-medium text-base mb-1 w-fit">Mark consultation</h1>

                                <label for="followup-date-cons" class="font-medium">Post consultation follow-up date</label>
                                <input id="followup-date-cons" name="followup_date" required type="date" class=" rounded-lg input-info bg-base-200 w-full lg:w-72 mt-1.5">

                                <div class=" flex space-x-2 mt-1 w-fit">
                                    <button type="submit" class="btn btn-primary btn-xs ">Proceed</button>
                                </div>
                            </form>
</div>
