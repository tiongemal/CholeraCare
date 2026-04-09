<div>
    <label for="location" class="form-label">Location</label>
    <select class="form-control" id="location" name="location" required>
        <option value="" disabled selected>Select a district</option>
        <option value="Balaka">Balaka</option>
        <option value="Blantyre">Blantyre</option>
        <option value="Chikwawa">Chikwawa</option>
        <option value="Chiradzulu">Chiradzulu</option>
        <option value="Chitipa">Chitipa</option>
        <option value="Dedza">Dedza</option>
        <option value="Dowa">Dowa</option>
        <option value="Karonga">Karonga</option>
        <option value="Kasungu">Kasungu</option>
        <option value="Likoma">Likoma</option>
        <option value="Lilongwe">Lilongwe</option>
        <option value="Machinga">Machinga</option>
        <option value="Mangochi">Mangochi</option>
        <option value="Mchinji">Mchinji</option>
        <option value="Mulanje">Mulanje</option>
        <option value="Mwanza">Mwanza</option>
        <option value="Mzimba">Mzimba</option>
        <option value="Neno">Neno</option>
        <option value="Nkhatabay">Nkhatabay</option>
        <option value="Nkhotakota">Nkhotakota</option>
        <option value="Nsanje">Nsanje</option>
        <option value="Ntcheu">Ntcheu</option>
        <option value="Ntchisi">Ntchisi</option>
        <option value="Phalombe">Phalombe</option>
        <option value="Rumphi">Rumphi</option>
        <option value="Salima">Salima</option>
        <option value="Thyolo">Thyolo</option>
        <option value="Zomba">Zomba</option>

    </select>
</div>

<script>
    $(document).ready(function() {
        $('#location').select2({
            placeholder: "Select or type to search",
            allowClear: true
        });
    });
</script>
