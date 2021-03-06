
{{ content() }}

{% set sumD1 = 0 %}{% set sumD2 = 0 %}{% set sumD3 = 0 %}{% set sumD4 = 0 %}
{% set subD1 = 0 %}{% set subD2 = 0 %}{% set subD3 = 0 %}{% set subD4 = 0 %}
{% set lastarea = '' %}{% set currarea = '' %}

<style type="text/css">
    @media print{@page {size: A4 landscape}}
</style>
<table class="tablePrint" style="width:900px">
    <tr>
        <td colspan="7">
            <table style="width:100%;">
                <tr>
                    <td align="center"><img src="{{ url('img/logo_new_web.png') }}" width="125%"></td>
                    <td align="center" width="64%">
                        <h2><u>{{ rpt_title }}</u></h2>
                    </td>
                    <td width="18%" align="right">
                        <a href="#" id="downloadBtn" class="btn btn-primary pull-right">Download</a>
                        <a href="javascript:void();" onclick="window.print();" id="printLink" class="btn btn-success pull-right">Print</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3 style="margin: 4px 0">Area : {{ rpt_area }}, Cabang : {{ rpt_cabang }}</h3>
                    </td>
                    <td>
                        <h3 class="text-right" style="margin:4px 0">Periode : {{ periode }}</h3>
                    </td>
                </tr>
            </table>    
        </td>
    </tr>
    <tr>
        <td colspan="7"><hr color="#000000"/></td>
    </tr>
    <tr>
        <td colspan="7">
            <table class="table bordered hovered table2excel" style="width: 100%; border-collapse: collapse">
                <thead>
                    <tr>
                        <th width="4%">#</th>
                        <th width="12%">No. Induk Siswa</th>
                        <th width="28%">Nama Siswa</th>
						<th width="12%">Jenjang</th>
                    
                        <th width="12%">Biaya Bimbingan</th>
                        <th width="12%">Total Pembayaran per Periode Laporan</th>
                        <th width="12%">Sisa Pembayaran per Periode Laporan</th>
                     
                    </tr>
                </thead>
                <tbody>
                    {% if result is not empty %}
                        {% for list in result %}
                            {% set currarea = list.KodeCabang %}
                            {% if currarea != lastarea and not loop.first %}
                                <tr class="text-right" style="background: #f0f0f0; font-weight: bold">
                                    <td class="text-center" colspan="4">Sub Total</td>
                                    <td>{{ subD1|number_format(0,',','.') }}</td>
                                    <td>{{ subD2|number_format(0,',','.') }}</td>
                                    <td>{{ subD3|number_format(0,',','.') }}</td>
                                    <td>{{ subD4|number_format(0,',','.') }}</td>
                                </tr>
                                {% set subD1 = 0 %}{% set subD2 = 0 %}{% set subD3 = 0 %}
                            {% endif %}
                            {% set subD1 += list.BiayaBimbingan %}
                            {% set subD2 += list.TotalPembayaran %}
                            {% set subD3 += list.TotalPiutang %}
                            {% set subD4 += list.TotalPembayaranVA %}
                            {% set sumD1 += list.BiayaBimbingan %}
                            {% set sumD2 += list.TotalPembayaran %}
                            
                            {% set sumD4 += list.TotalPembayaranVA %}
                            {% if currarea != lastarea %}
                                <tr style="font-weight: bold">
                                    <td>&nbsp;</td>
                                    <td colspan="5">
                                        &nbsp;Cabang : {{ list.KodeCabang~' - '~list.NamaCabang }}
                                    </td>
                                </tr>
                            {% endif %}
                            <tr class="text-center">
                                <td>{{ loop.index }}</td>
                                <td>{{ list.NIS }}</td>
                                <td class="text-left">{{ list.NamaSiswa|upper }}</td>
								<td class="text-left">{{ list.NamaJenjang}}</td>
                                {% set tot = list.BiayaBimbingan-list.TotalPembayaran %}
                                <td class="text-right">{{ list.BiayaBimbingan|number_format(0,',','.') }}</td>
                                <td class="text-right">{{ list.TotalPembayaran|number_format(0,',','.') }}</td>
                                <td class="text-right">{{ tot|number_format(0,',','.') }}</td>
								{% set sumD3 += tot %}
                          
                            </tr>
                            {% if loop.last %}
                                <tr class="text-right" style="background: #f0f0f0; font-weight: bold">
                                    <td class="text-center" colspan="4">Sub Total</td>
                                    <td>{{ subD1|number_format(0,',','.') }}</td>
                                    <td>{{ subD2|number_format(0,',','.') }}</td>
                                    <td>{{ sumD3|number_format(0,',','.') }}</td>
                                   
                                </tr>
                                <tr class="text-right" style="background: #f0f0f0; font-weight: bold">
                                    <td class="text-center" colspan="4">Grand Total</td>
                                    <td>{{ sumD1|number_format(0,',','.') }}</td>
                                    <td>{{ sumD2|number_format(0,',','.') }}</td>
                                    <td>{{ sumD3|number_format(0,',','.') }}</td>
                                   
                                </tr>

                            {% endif %}
                            {% set lastarea = currarea %}
                        {% endfor %}
                    {% else %}
                        <tr>
                            <td colspan="12" align="center">- Tidak Ada Data -</td>
                        </tr>
                    {% endif %}
                </tbody>
            </table>

        </td>
    </tr>
</table>

<script>
    $('#downloadBtn').on('click', function () {
        $(".table2excel").table2excel({
            exclude: ".noExl",
            name: "Primaedu",
            filename: "{{ rpt_title }}.xls"
        });
    });
</script>
