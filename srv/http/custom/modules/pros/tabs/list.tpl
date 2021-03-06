Name = Список

<div class = "puz">
<H3> Список процессов</h3>
&:<span>`info.sh@`</span>:&

<table id="list_service">
		<thead>
		<tr>
			<th>PID</th>
			<th>Пользователь</th>
			<th>CPU</th>
			<th>MEM</th>
			<th>Время</th>
			<th>Процесс</th>
	</tr>
	</thead>
	<tboby>
	&:<tr>
		&:<td><p>`pross.sh@6`</p></td>:&
	</tr>:&
	</tboby>
	</table>
</div>

<style>
form
{
	padding: 2px;
}
input
{
	width: 80% !important;
    display: inline-block !important;
    background: none !important;
    text-align: center;
    border: none !important;
}
.list_log
{
	width: 300px;
}
table
{
	width: 100%;
	margin-top: 15px;
	word-break: break-all;
}

td
{
	padding-left: 5px;
}

td:nth-child(1)
{
	width: 10%;
}

td:nth-child(2)
{
	width: 13%;
}

td:nth-child(3),
td:nth-child(4)
{
	width: 7%;
	text-align: center;
}

tr:nth-child(2n+1)
{
	background: rgba(52,141,216,0.3);
}
th
{
	background: rgba(52,141,216,0.3);
	background: rgba(52,141,216,0.3);
    padding-left: 5px;
    text-transform: uppercase;
}
button
{
    background: rgba(237,83,17,0.3);
    width: 23% !important;
    font-size: 11px;
    padding-bottom: 10px;
    padding-top: 10px;
    border-radius: 3px;
    border-width: 0px;
    cursor: pointer;
    word-break: break-word;
    color: #FFF6E8;
    text-transform: uppercase;
}
h3
{
	text-align: center;
    text-transform: uppercase;
    color: #203D61;
}

.puz button:nth-of-type(2)
{
	background-color: #b65b4f;
}

.puz button:nth-of-type(3)
{
	background-color: #bf8d5b;
}
.puz button:nth-of-type(4)
{
	background-color: #3A6B76;
}
.arrow
{
	width: 15px;
}
</style>

<SCRIPT src="/kernel/js/sort_table.js"></script>

<script>

	$("#list_service").tablesorter();

	$("th").click(

	function()
	{
		test = $(this).find("img").attr('class');

		if ( test == undefined )
			direction = "up"
		else
		{
			direction = $(this).children('img').attr('id');

			if ( direction == "up" )
				direction = "down"
			else
				direction = "up"

		}

		$('.arrow').detach();
		str = "<img src='/custom/pic/"+direction+"_arrow.png' class='arrow' id='"+direction+"'>";
		$(this).append(str);
	}

	)

	$('th:nth-child(1)').trigger('click');

</script>