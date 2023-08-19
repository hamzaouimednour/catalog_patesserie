                        @if ($modules->isNotEmpty())
                            <div id="modal-add-msg"></div>
                                
                            <div class="form-group mg-b-0 pd-b-15">
                                <label for="field-a1">Groupe d'autorisation : <span class="tx-danger">*</span></label>
                                <input id="field-a1" type="text" name="group" class="form-control"
                                    placeholder="Nom du Groupe" required>
                                <div class="invalid-feedback">Ce champ est obligatoire</div>
                            </div><!-- form-group -->
                            
                            <div class="form-group mg-b-0 pd-b-15">
                                <label for="field-a2">Modules <small>(<b>Consultation</b> c'est le droit par défaut)</small> : <span class="tx-danger">*</span></label>

                            @foreach ($modules as $item)
                            <div class="form-group mg-b-0 pd-b-15 pd-t-10">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <label for="" class="tx-inverse tx-bold tx-16 mg-t-5">{{$item->module}} : </label>
                                        <div class="item-actions br-toggle br-toggle-rounded br-toggle-success float-right pd-t-5" id="{{$item->id}}">
                                            <div class="br-toggle-switch"></div>
                                        </div>
                                    </li>
                                    <li id="actions-{{$item->id}}" class="list-group-item d-none">
                                        <ul class="list-group">
                                            @php
                                                $actions = json_decode($item->actions, true);
                                            @endphp
                                            @if (in_array('A', $actions))
                                                <li class="list-group-item">
                                                    <label class="ckbox ckbox-success mg-l-10 mg-t-15">
                                                        <input class="action-item" type="checkbox" name="actions[]" value="A"><span>Ajout</span>
                                                    </label>
                                                </li>
                                            @endif
                                            @if (in_array('M', $actions))
                                                <li class="list-group-item">
                                                    <label class="ckbox ckbox-success mg-l-10 mg-t-15">
                                                        <input class="action-item" type="checkbox" name="actions[]" value="M"><span>Modification</span>
                                                    </label>
                                                </li>  
                                            @endif
                                            @if (in_array('D', $actions))
                                                <li class="list-group-item">
                                                    <label class="ckbox ckbox-success mg-l-10 mg-t-15">
                                                        <input class="action-item" type="checkbox" name="actions[]" value="D"><span>Suppression</span>
                                                    </label>
                                                </li>  
                                            @endif
                                            @if (in_array('P', $actions))
                                                <li class="list-group-item">
                                                    <label class="ckbox ckbox-success mg-l-10 mg-t-15">
                                                        <input class="action-item" type="checkbox" name="actions[]" value="P"><span>Impression</span>
                                                    </label>
                                                </li>  
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- form-group -->
                            @endforeach
                            </div><!-- form-group -->
                            <div class="form-group mg-b-0">
                                <label for="field-a6">Statut : <small>(Active par défaut)</small>&nbsp;&nbsp;</label>
                                <br>
                                <div style="bottom:-6px" class="mg-l-5 br-toggle br-toggle-success on">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div><!-- form-group -->
                        @else
                             <div class="form-group mg-b-0 pd-b-10">
                                <label for="field-e1">Aucun Module trouvé.</label>
                             </div>
                        @endif