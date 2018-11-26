<?php require_once("common/header.php"); ?>


<!-- Main content -->
<div class="main-content">
  <!-- Top navbar -->
  <?php require_once("common/nav.php"); ?>
  <!-- Header -->
  <div class="header bg-gradient-primary pb-4 pt-4 pt-md-6">
    <div class="container-fluid">
      <div class="header-body">
        <!-- Card stats -->

      </div>
    </div>
  </div>
  <!-- Page content -->
  <div class="container-fluid mt--7">

    <div class="row mt-8 maxheight">
      <div class="col-xl-8 mb-8 mb-xl-0 offset-2">
        <div class="card shadow">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Messages</h3>
              </div>
              <div class="col offset-4 text-right">
                <form id="sendMessage">
                  <select class="form-control" id="usersList">
                    <option value="">Select user</option>
                  </select>
                </form>
              </div>

              <div class="col text-right">
                <a href="#" id="sayHi" class="btn btn btn-success">Say Hi</a>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Sent By</th>
                  <th scope="col">Datetime</th>
                </tr>
              </thead>
              <tbody id="content-body">

              </tbody>
            </table>
          </div>

        </div>
        <div class="float-right mt-5">

          <nav aria-label="...">
            <ul class="pagination">
              <li class="page-item prev">
                <a class="page-link" href="#" tabindex="-1">
                  <i class="fa fa-angle-left"></i>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li class="page-item next">
                <a class="page-link" href="#">
                  <i class="fa fa-angle-right"></i>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

    </div>

    <script src="assets/js/messages.js"></script>
    <?php require_once("common/footer.php"); ?>