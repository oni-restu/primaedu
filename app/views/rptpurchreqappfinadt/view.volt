
{{ content() }}

{% set lastarea = '' %}{% set lastcabang = '' %}{% set lastpurchreq = '' %}
{% set tmpcabang = '' %}
{% set lastcabang = '' %}
{% set konfr = '' %}
{% set lines = '' %}


<style type="text/css">
    @media print {@page {size: A4 landscape}}
    .text-top { vertical-align: top }
</style>
<table class="tablePrint" style="width:100%;">
    <tr>
        <td colspan="7">
            <table style="width:100%;">
                <tr>
                    <td align="center"><img src="{{ url('img/logo_new_web.png') }}" width="220"></td>
                    <td align="center" width="75%">
                        <h2><u>{{ rpt_title }}</u></h2>
                    </td>
                    <td width="20%" align="right">
                        <a href="#" id="downloadBtn" class="btn btn-primary pull-right">Download</a>
                        <a href="javascript:void();" onclick="window.print();" id="printLink" class="btn btn-success pull-right">Print</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h3 class="text-right" style="margin:4px 0">Area : {{ area }}, Periode : {{ periode }} - {{ periodeakhir }}</h3>
                    </td>
                </tr>
            </table>    
        </td>
    </tr>
    <tr>
        <td colspan="7"><hr color="#000000"/></td>
    </tr>
</table>

{% set tmpcabang = '' %}
{% set lastcabang = '' %}
{% set konfr = '' %}
{% set lines = '' %}

{% if result is not empty %}
    <table id="excel" class="table table2excel" style="table-layout: fixed !important;border: none">
        {% for list in result %}
            {% if list.Cabang != lastcabang AND not loop.first %}
                {{'</table></td></tr>'}}
            {% endif %}
            {% if list.Cabang != lastcabang %}
                {{'<tr><td>'}}
                {{'<table class="table bordered" style="table-layout: fixed !important;border-collapse: collapse">'}}
                {% set tmpcabang = list.Areacabang %}
                <thead>
                <h3>CABANG : {{ tmpcabang.KodeAreaCabang ~ ' - ' ~ tmpcabang.NamaAreaCabang }}</h3>
                <tr>
                    <th rowspan="2" style="width: 220px">Kode Pembelian</th>
                    <th rowspan="2" style="width: 220px">Tanggal Pembelian</th>
                    <th rowspan="2" style="width: 320px">Approved Finance</th>
                    <th rowspan="2" style="width: 240px">Kode Smartbook</th>
                    <th colspan="3" style="width: 310px">Jumlah (Qty.)</th>
                </tr>
                <tr>
                    <th style="width: 70px">Pembelian</th>
                    <th style="width: 70px">Sisa Pembelian</th>
                    <th style="width: 70px">Sudah Diterima</th>
                </tr>
            </thead>
        {% endif %}
        <tr>
            {% set lines = list.Purchreqline %}
            {% set konfr = list.Konfirmasi %}
            <td rowspan="{{ lines|length }}" class="text-top text-center">{{ list.PurchReqId }}</td>
            <td rowspan="{{ lines|length }}" class="text-top text-center">{{ list.PurchReqDate }}</td>
            <td rowspan="{{ lines|length }}" class="text-top text-center">
            
            {{ konfr.Status }}
  
            {{ konfr.ApprovalDate }}

            </td>
            {% for detail in lines %}
                {% if not loop.first %}{{'<tr>'}}{% endif %}
                <td>{{ detail.ItemId }}</td>
                <td>{{ detail.Qty }}</td>
                <td>{{ detail.QtyRemaining }}</td>
                <td>{{ detail.QtyReceived }}</td>
                {% if not loop.first %}{{'</tr>'}}{% endif %}
            {% else %}
                <td colspan="5" class="text-center">- Tidak Ada Smartbook -</td>
            {% endfor %}
        </tr>
        {% if loop.last %}
            {{'</table></td></tr>'}}
        {% endif %}
        {% set lastcabang = list.Cabang %}
    {% else %}
        <tr><td>- Tidak Ada Pembelian -</td></tr>
    {% endfor %}
</table>
{% endif %}
{{ javascript_include('js/jquery/jquery.tabletoexcel.js') }}
<script>
    $('#downloadBtn').on('click', function () {
        tableToExcel('excel', '{{ rpt_title }}');
    });
</script>
