<html>
<head>
  <meta charset="utf-8" />
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style type="text/css">
    p, body, td, input, select, button { font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif; font-size: 14px; }
    body { padding: 0px; margin: 0px; background-color: #ffffff; }
    a { color: #1155a3; }
    .space { margin: 10px 0px 10px 0px; }
    .header { background: #003267; background: linear-gradient(to right, #011329 0%,#00639e 44%,#011329 100%); padding:20px 10px; color: white; box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.75); }
    .header a { color: white; }
    .header h1 a { text-decoration: none; }
    .header h1 { padding: 0px; margin: 0px; }
    .main { padding: 10px; margin-top: 10px; }
  </style>

  <style>
      .toolbar {
          margin-bottom: 10px;
      }

      .toolbar-item a {
          background-color: #fff;
          border: 1px solid #c0c0c0;
          color: #333;
          padding: 8px 0px;
          width: 80px;
          border-radius: 2px;
          cursor: pointer;
          display: inline-block;
          text-align: center;
          text-decoration: none;
      }

      .toolbar-item a.selected-button {
          background-color: #f3f3f3;
          color: #000;
      }

      /* context menu icons */
      .icon:before {
          position: absolute;
          margin-left: 0px;
          margin-top: 3px;
          width: 14px;
          height: 14px;
          content: '';
      }

      .icon-blue:before { background-color: #3d85c6; }
      .icon-green:before { background-color: #6aa84f; }
      .icon-orange:before { background-color: #e69138; }
      .icon-red:before { background-color: #cc4125; }

      /* active areas */
      .area-menu-icon {
          background-color: #333333;
          box-sizing: border-box;
          border-radius: 10px;
          opacity: 0.7;
          color: white;
          display: flex;
          justify-content: center;
          font-size: 14px;
      }
  </style>

  <!-- DayPilot library -->
  <script src="js/daypilot/daypilot-all.min.js"></script>

</head>
<body>
<div class="main">
  <div style="display:flex">
    <div style="">
      <div id="nav"></div>
    </div>
    <div style="flex-grow: 1; margin-left: 10px;">
      <div class="toolbar buttons">
        <span class="toolbar-item"><a id="buttonDay" href="#">Day</a></span>
        <span class="toolbar-item"><a id="buttonWeek" href="#">Week</a></span>
        <span class="toolbar-item"><a id="buttonMonth" href="#">Month</a></span>
      </div>
      <div id="dpDay"></div>
      <div id="dpWeek"></div>
      <div id="dpMonth"></div>
    </div>
  </div>
</div>

<script type="text/javascript">


  const nav = new DayPilot.Navigator("nav");
  nav.showMonths = 3;
  nav.skipMonths = 3;
  nav.init();

  const day = new DayPilot.Calendar("dpDay");
  day.viewType = "Day";
  configureCalendar(day);
  day.init();

  const week = new DayPilot.Calendar("dpWeek");
  week.viewType = "Week";
  configureCalendar(week);
  week.init();

  const month = new DayPilot.Month("dpMonth");
  configureCalendar(month);
  month.init();

  function configureCalendar(dp) {
    dp.contextMenu = new DayPilot.Menu({
      items: [
        {
          text: "Delete",
          onClick: async args => {
            var params = {
              id: args.source.id(),
            };
            await DayPilot.Http.post("calendar_delete.php", params);
            dp.events.remove(params.id);
            console.log("Deleted");
          }
        },
        {
          text: "-"
        },
        {
          text: "Blue",
          icon: "icon icon-blue",
          color: "#3d85c6",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Green",
          icon: "icon icon-green",
          color: "#6aa84f",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Orange",
          icon: "icon icon-orange",
          color: "#e69138",
          onClick: args => { updateColor(args.source, args.item.color); }
        },
        {
          text: "Red",
          icon: "icon icon-red",
          color: "#cc4125",
          onClick: args => { updateColor(args.source, args.item.color); }
        }
      ]
    });


    dp.onBeforeEventRender = args => {
      if (!args.data.backColor) {
        args.data.backColor = "#6aa84f";
      }
      args.data.borderColor = "darker";
      args.data.fontColor = "#fff";
      args.data.barHidden = true;

      args.data.areas = [
        {
          right: 2,
          top: 2,
          width: 20,
          height: 20,
          html: "&equiv;",
          action: "ContextMenu",
          cssClass: "area-menu-icon",
          visibility: "Hover"
        }
      ];
    };


    dp.onEventClick = args => {
      DayPilot.Modal.alert(args.e.data.text + " | " + args.e.data.email);
    };
  }

  const switcher = new DayPilot.Switcher({
    triggers: [
      {id: "buttonDay", view: day },
      {id: "buttonWeek", view: week},
      {id: "buttonMonth", view: month}
    ],
    navigator: nav,
    selectedClass: "selected-button",
    onChanged: args => {
      console.log("onChanged fired");
      switcher.events.load("calendar_events.php");
    }
  });

  switcher.select("buttonWeek");

  async function updateColor(e, color) {
    const params = {
      id: e.data.id,
      color: color
    };

    await DayPilot.Http.post("calendar_color.php", params);
    const dp = switcher.active.control;
    e.data.backColor = color;
    dp.events.update(e);
    console.log("Color updated");
  }

</script>

</body>
</html>

