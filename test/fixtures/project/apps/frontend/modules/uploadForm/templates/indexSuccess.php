<h1>Upload Form</h1>

<?php echo form_tag('uploadForm/upload') ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="Upload!" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>